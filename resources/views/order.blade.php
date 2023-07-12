<x-layout>
    <div>
        <div style="margin-bottom: 2rem;">
            <h1 style="color: grey;">Order</h1>
        </div>
        <div style="margin-bottom: 2rem;" class="input-group">
            <span style="color: grey;" class="input-group-text" id="inputGroup-sizing-default">Search Product</span>
            <input style="color: grey;" id="search" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" placeholder="...you can search by ID or name here">
        </div>
        <div>
            <form class="modal-content" id="orderForm" method="POST">
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label style="color: grey;" for="id" class="col-md col-form-label">Product ID</label>
                        <div class="col-md">
                            <input style="color: grey;" id="product_id" type="text" name="product_id" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label style="color: grey;" for="name" class="col-md col-form-label">Product Name</label>
                        <div class="col-md">
                            <input style="color: grey;" id="name" type="text" name="name" disabled>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label style="color: grey;" for="price" class="col-md col-form-label">Price</label>
                        <div class="col-md">
                            <input style="color: grey;" id="price" type="text" name="price" disabled>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label style="color: grey;" for="quantity" class="col-md col-form-label">Quantity</label>
                        <div class="col-md">
                            <input style="color: grey;" type="number" name="quantity">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md">
                            <input type="hidden">
                        </div>
                        <div class="col-lg">
                            <button type="submit" class="btn btn-success">Place Order</button>
                        </div>
                    </div>
                </div>
            </form>
            <div style="margin-top: 1rem;">
                <h4 style="color: grey;">Summary</h4>
            </div>
            <hr>
            <x-order-table />
            <div class="modal fade" id="editOrderModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form class="modal-content" id="editOrderForm" method="PUT">
                        <div class="modal-header">
                            <h1 style="color: grey;" class="modal-title fs-5" id="staticBackdropLabel">Edit Order</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3 row">
                                <label style="color: grey;" for="order_id" class="col-md col-form-label">Product ID</label>
                                <div class="col-md">
                                    <input style="color: grey;" id="order_id" type="text" name="id" readonly>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label style="color: grey;" for="name" class="col-md col-form-label">Product Name</label>
                                <div class="col-md">
                                    <input style="color: grey;" id="product_name" type="text" name="name" disabled>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label style="color: grey;" for="price" class="col-md col-form-label">Price</label>
                                <div class="col-md">
                                    <input style="color: grey;" id="selling_price" type="text" name="price" disabled>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label style="color: grey;" for="tax_rate" class="col-md col-form-label">Tax Rate</label>
                                <div class="col-md">
                                    <input style="color: grey;" id="tax_rate" type="text" name="tax_rate" disabled>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label style="color: grey;" for="total_price" class="col-md col-form-label">Total Price</label>
                                <div class="col-md">
                                    <input style="color: grey;" id="total_price" type="text" name="total_price" disabled>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label style="color: grey;" for="order_at" class="col-md col-form-label">Order At</label>
                                <div class="col-md">
                                    <input style="color: grey;" id="order_at" type="text" name="created_at" disabled>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label style="color: grey;" for="quantity" class="col-md col-form-label">Quantity</label>
                                <div class="col-md">
                                    <input id="quantity" style="color: grey;" type="quantity" name="quantity">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Continue</button>
                        </div>
                    </form>
                </div>
            </div>
            <script src="{{ asset('js/order-submit.js') }}"></script>
            <script src="{{ asset('js/product-search.js') }}"></script>
        </div>
    </div>
</x-layout>
