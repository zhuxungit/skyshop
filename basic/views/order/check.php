<!-- ============================================================= HEADER : END ============================================================= -->        <!-- ========================================= CONTENT ========================================= -->

<section id="checkout-page">
    <div class="container">
        <div class="col-xs-12 no-margin">

            <div class="billing-address">
                <h2 class="border h1">billing address</h2>
                <form>
                    <div class="row field-row">
                        <div class="col-xs-12 col-sm-6">
                            <label>full name*</label>
                            <input class="le-input">
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <label>last name*</label>
                            <input class="le-input">
                        </div>
                    </div><!-- /.field-row -->

                    <div class="row field-row">
                        <div class="col-xs-12">
                            <label>company name</label>
                            <input class="le-input">
                        </div>
                    </div><!-- /.field-row -->

                    <div class="row field-row">
                        <div class="col-xs-12 col-sm-6">
                            <label>address*</label>
                            <input class="le-input" data-placeholder="street address">
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <label>&nbsp;</label>
                            <input class="le-input" data-placeholder="town">
                        </div>
                    </div><!-- /.field-row -->

                    <div class="row field-row">
                        <div class="col-xs-12 col-sm-4">
                            <label>postcode / Zip*</label>
                            <input class="le-input">
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <label>email address*</label>
                            <input class="le-input">
                        </div>

                        <div class="col-xs-12 col-sm-4">
                            <label>phone number*</label>
                            <input class="le-input">
                        </div>
                    </div><!-- /.field-row -->

                    <div class="row field-row">
                        <div id="create-account" class="col-xs-12">
                            <input class="le-checkbox big" type="checkbox"/>
                            <a class="simple-link bold" href="#">Create Account?</a> - you will receive email with temporary generated password after login you
                            need to change it.
                        </div>
                    </div><!-- /.field-row -->

                </form>
            </div><!-- /.billing-address -->


            <section id="shipping-address">
                <h2 class="border h1">shipping address</h2>
                <form>
                    <div class="row field-row">
                        <div class="col-xs-12">
                            <input class="le-checkbox big" type="checkbox"/>
                            <a class="simple-link bold" href="#">ship to different address?</a>
                        </div>
                    </div><!-- /.field-row -->
                </form>
            </section><!-- /#shipping-address -->


            <section id="your-order">
                <h2 class="border h1">your order</h2>
                <form>
                    <div class="row no-margin order-item">
                        <div class="col-xs-12 col-sm-1 no-margin">
                            <a href="#" class="qty">1 x</a>
                        </div>

                        <div class="col-xs-12 col-sm-9 ">
                            <div class="title"><a href="#">white lumia 9001 </a></div>
                            <div class="brand">sony</div>
                        </div>

                        <div class="col-xs-12 col-sm-2 no-margin">
                            <div class="price">$2000.00</div>
                        </div>
                    </div><!-- /.order-item -->

                    <div class="row no-margin order-item">
                        <div class="col-xs-12 col-sm-1 no-margin">
                            <a href="#" class="qty">1 x</a>
                        </div>

                        <div class="col-xs-12 col-sm-9 ">
                            <div class="title"><a href="#">white lumia 9001 </a></div>
                            <div class="brand">sony</div>
                        </div>

                        <div class="col-xs-12 col-sm-2 no-margin">
                            <div class="price">$2000.00</div>
                        </div>
                    </div><!-- /.order-item -->

                    <div class="row no-margin order-item">
                        <div class="col-xs-12 col-sm-1 no-margin">
                            <a href="#" class="qty">1 x</a>
                        </div>

                        <div class="col-xs-12 col-sm-9 ">
                            <div class="title"><a href="#">white lumia 9001 </a></div>
                            <div class="brand">sony</div>
                        </div>

                        <div class="col-xs-12 col-sm-2 no-margin">
                            <div class="price">$2000.00</div>
                        </div>
                    </div><!-- /.order-item -->
                </form>
            </section><!-- /#your-order -->

            <div id="total-area" class="row no-margin">
                <div class="col-xs-12 col-lg-4 col-lg-offset-8 no-margin-right">
                    <div id="subtotal-holder">
                        <ul class="tabled-data inverse-bold no-border">
                            <li>
                                <label>cart subtotal</label>
                                <div class="value ">$8434.00</div>
                            </li>
                            <li>
                                <label>shipping</label>
                                <div class="value">
                                    <div class="radio-group">
                                        <input class="le-radio" type="radio" name="group1" value="free">
                                        <div class="radio-label bold">free shipping</div>
                                        <br>
                                        <input class="le-radio" type="radio" name="group1" value="local" checked>
                                        <div class="radio-label">local delivery<br><span class="bold">$15</span></div>
                                    </div>
                                </div>
                            </li>
                        </ul><!-- /.tabled-data -->

                        <ul id="total-field" class="tabled-data inverse-bold ">
                            <li>
                                <label>order total</label>
                                <div class="value">$8434.00</div>
                            </li>
                        </ul><!-- /.tabled-data -->

                    </div><!-- /#subtotal-holder -->
                </div><!-- /.col -->
            </div><!-- /#total-area -->

            <div id="payment-method-options">
                <form>
                    <div class="payment-method-option">
                        <input class="le-radio" type="radio" name="group2" value="Direct">
                        <div class="radio-label bold ">Direct Bank Transfer<br>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce rutrum tempus elit, vestibulum vestibulum erat ornare id.</p>
                        </div>
                    </div><!-- /.payment-method-option -->

                    <div class="payment-method-option">
                        <input class="le-radio" type="radio" name="group2" value="cheque">
                        <div class="radio-label bold ">cheque payment</div>
                    </div><!-- /.payment-method-option -->

                    <div class="payment-method-option">
                        <input class="le-radio" type="radio" name="group2" value="paypal">
                        <div class="radio-label bold ">paypal system</div>
                    </div><!-- /.payment-method-option -->
                </form>
            </div><!-- /#payment-method-options -->

            <div class="place-order-button">
                <button class="le-button big">place order</button>
            </div><!-- /.place-order-button -->

        </div><!-- /.col -->
    </div><!-- /.container -->
</section><!-- /#checkout-page -->
<!-- ========================================= CONTENT : END ========================================= -->        <!-- ============================================================= FOOTER ============================================================= -->
