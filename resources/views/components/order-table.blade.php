<div>
    <div style="margin-top: 2rem; margin-bottom: 2rem;">
        <div class="d-flex" style="margin-bottom: 2rem;">
            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 25%">
                <i class="fa fa-calendar"></i>&nbsp;
                <span></span> <i class="fa fa-caret-down"></i>
            </div>
            <div class="btn-group" role="group" aria-label="Basic example">
                <button id="download-excel" type="button" class="btn btn-success">
                    <i class="fa fa-download"></i>&nbsp;
                    Download Excel
                </button>
                <button id="download-pdf" type="button" class="btn btn-warning">
                    <i class="fa fa-download"></i>&nbsp;
                    Download PDF
                </button>
            </div>
        </div>
        <table id="orderTable" class="display">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product</th>
                    <th>Selling Price</th>
                    <th>Quantity</th>
                    <th>Tax Rate</th>
                    <th>Total Price</th>
                    <th>Order At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <script src="{{ asset('js/order-table.js') }}"></script>
    </div>
</div>
