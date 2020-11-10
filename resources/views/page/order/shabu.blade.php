<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-12">
                    <img src="{{ asset('page/assets/images/product/shabu.jpg') }}"
                        class="imageproduct">
                </div>
                <div class="col-lg-8">
                    <div class="label_rating">9.0</div>
                    <div class="row valuerating">
                        <div class="star-rating">
                            <input type="radio" id="5-stars" name="rating" value="5" />
                            <label for="5-stars" class="star">&#9733;</label>
                            <input type="radio" id="4-stars" name="rating" value="4" />
                            <label for="4-stars" class="star">&#9733;</label>
                            <input type="radio" id="3-stars" name="rating" value="3" />
                            <label for="3-stars" class="star">&#9733;</label>
                            <input type="radio" id="2-stars" name="rating" value="2" />
                            <label for="2-stars" class="star">&#9733;</label>
                            <input type="radio" id="1-star" name="rating" value="1" />
                            <label for="1-star" class="star">&#9733;</label>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="container">
                        <div class="col-lg-12">
                            <p class="text-card-order">Lorem ipsum dolor sit amet,
                                consectetur
                                adipiscing elit. Fringilla sed tellus orci praesent sem
                                eget.
                                Amet eu, habitant id vel magna vitae </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-4">
            <div class="paket_general">
                <p> <span class="currency-general">Rp 100.000</span><span
                        class="sub-currency">/ Paket</span></p>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="input-groups">
                        <span class="input-group-btn">
                            <button type="button" class="tombols btn-number"
                                disabled="disabled" data-type="minus" data-field="quant[1]">
                                <i class="icofont-minus icon-number"></i>
                            </button>
                        </span>
                        <input type="text" name="quant[1]" class="form-nedd input-number"
                            value="1" min="1" max="1000">
                        <span class="input-group-btn">
                            <button type="button" class="tombols btn-number" data-type="plus"
                                data-field="quant[1]">
                                <i class="icofont-plus icon-number"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
             <div class="col-sm-12">
                <select class="select_menu_order" id="exampleFormControlSelect1">
                    <option disabled selected> Pilih Kaldu </option>
                    <option>Tomyam</option>
                    <option>Kaldu</option>
                  </select>
             </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <button class="tombol-lg tombol-keranjang">Masukkan Keranjang</button>
                </div>
            </div>
        </div>
    </div>
</div>