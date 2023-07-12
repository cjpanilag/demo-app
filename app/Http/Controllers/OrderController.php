<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderCollection;
use App\Models\Order;
use App\Models\Product;
use App\Models\Tax;
use Illuminate\Http\JsonResponse;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Rap2hpoutre\FastExcel\Facades\FastExcel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class OrderController extends Controller
{

    public function index(): JsonResponse
    {
        $data = QueryBuilder::for(Order::class)
            ->allowedFilters([
                AllowedFilter::scope('order_date_range')
            ])
            ->defaultSort('-updated_at')
            ->paginate(10);

        return successResponseJson($data, 'Successfully fetched records.', 200);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required'
        ]);

        $product_id = $request->product_id;
        $quantity = $request->quantity;
        $tax = Tax::select(DB::raw("CAST((CAST(value as DECIMAL(10,2))/100) as DECIMAL(10,2)) as tax_value"))->first();

        $product = $product = Product::select(
            DB::raw(
                "CAST((CAST(price as DECIMAL(10,2)) + (CAST(price as DECIMAL(10,2)) * CAST({$tax->tax_value} as DECIMAL(10,2))))
                  * $quantity as DECIMAL(10,2)) as total_amount"
            ),
            'id'
        )->where('id', $product_id)->first();

        $result = Order::create([
            'product_id' => $product_id,
            'quantity' => $quantity,
            'total_amount' => $product->total_amount,
            'tax_id' => Tax::first()->id,
        ]);

        return successResponseJson($result, 'Successfully created record.', 201);
    }

    public function update(Request $request, Order $order): JsonResponse
    {
        $request->validate([
            'quantity' => 'required'
        ]);

        $quantity = $request->quantity;

        $product = Product::select(DB::raw("CAST(price as DECIMAL(10,2)) * $quantity as total_amount"))
            ->where('id', $order->product_id)
            ->first();

        $order->update(['quantity' => $quantity, 'total_amount' => $product->total_amount]);
        $result = $order->fresh();

        return successResponseJson($result, 'Successfully updated record.', 200);
    }

    public function delete(Order $order): JsonResponse
    {
        $order->delete();
        return successResponseJson([], 'Successfully deleted record.', 200);
    }

    public function export(Request $request)
    {
        $request->validate([
            'file_type' => 'required'
        ]);

        $allowed_file_types = ['excel', 'pdf'];

        if (in_array($request->file_type, $allowed_file_types) === false) {
            return response(null, 400);
        }

        $data = QueryBuilder::for(Order::class)
            ->allowedFilters([
                AllowedFilter::scope('order_date_range')
            ])
            ->defaultSort('-updated_at')
            ->get();

        $result = null;

        $data_collection = OrderCollection::collection($data);
        $data_collection = json_decode($data_collection->toJson(), true);

        switch ($request->file_type) {
            case 'excel':
                $result = FastExcel::data($data_collection)->download('file.xlsx');
                break;
            case 'pdf':
                $range = explode(',', $request->filter['order_date_range']);
                $view_data = [
                    'range' => [
                        'start_date' => Carbon::parse($range[0])->toFormattedDateString(),
                        'end_date' => Carbon::parse($range[1])->toFormattedDateString(),
                    ],
                    'data' => $data_collection
                ];
                $pdf = Pdf::loadView('pdf.order-report', $view_data);
                $result = $pdf->download('order-report.pdf');
                break;
        }

        return $result;
    }

    public function analytics(): JsonResponse
    {
        $orders = Order::select(
            DB::raw("SUM(total_amount) as total_sales"),
            DB::raw("SUM(quantity) as number_of_sales")
        )->get();

        return successResponseJson($orders[0], 'Successfully fetched records.', 200);
    }
}
