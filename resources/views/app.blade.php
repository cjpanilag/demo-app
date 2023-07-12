<x-layout>
    <div>
        <script src="{{ asset('js/analytics.js') }}"></script>
        <div>
            <h1 style="color: grey;">Dashboard</h1>
        </div>
        <div style="margin-top: 30px;" class="row">
            <div class="col">
                <div style="padding: 20px;" class="card">
                    <div class="d-flex justify-content-between">
                        <h5 style="color: grey;">Total Sales</h5>
                        <h5 id="total_sales" style="color: green;"></h5>
                    </div>
                </div>
            </div>
            <div class="col">
                <div style="padding: 20px;" class="card">
                    <div class="d-flex justify-content-between">
                        <h5 style="color: grey;">Items Sold</h5>
                        <h5 id="number_of_sales" style="color: green;"></h5>
                    </div>
                </div>
            </div>
        </div>
        <div style="margin-top: 3rem;" class="container">
            <div>
                <h4 style="color: grey;">Orders Summary</h4>
            </div>
            <hr>
            <x-order-table />
        </div>
    </div>
</x-layout>
