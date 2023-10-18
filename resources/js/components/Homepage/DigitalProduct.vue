<template>
    <section v-if="products.length != 0" class="mt-2 section new-arriavls feature-product-block">

        <h3 class="section-title">{{ translate('staticwords.DigitalProducts') }}</h3>



        <div v-if="!loading">

            <div :key="Math.random().toString(36).substring(7)"
                class="owl-carousel home-owl-carousel custom-carousel owl-theme outer-top-xs">

                <div v-for="product in products" :key="product.id" class="item item-carousel">

                    <div class="products">
                        <div class="product">
                            <div class="product-image">
                                <div :class="{'pro-img-box' : product.stock == 0 }" class="image">

                                    <a :href="product.url"
                                        :title="product.product_name[lang]  ? product.product_name[lang] : product.product_name[fallbacklang]">

                                        <span v-if="product.thumbnail">
                                            <img class="owl-lazy" :class="{'filterdimage' : product.stock == 0}"
                                                :data-src="product.thumbnail" alt="product_image" />
                                            <img :class="{'filterdimage' : product.stock == 0 }"
                                                class="owl-lazy hover-image" :data-src="product.hover_thumbnail"
                                                alt="product_image" />
                                        </span>


                                        <span v-else>
                                            <img :class="{'filterdimage' : product.stock == 0 }" class="owl-lazy"
                                                :title="product.product_name[lang]  ? product.product_name[lang] : product.product_name[fallbacklang]"
                                                :src="`${baseurl}'/images/no-image.png'}`" alt="No Image" />
                                        </span>


                                    </a>
                                </div>


                                <h6 v-if="product.stock == 0" align="center" class="oottext">
                                    <span>{{ translate('staticwords.Outofstock') }}</span></h6>

                               

                                <div v-else class="tag new"><span>{{ translate('staticwords.New') }}</span></div>

                            </div>


                            <!-- /.product-image -->

                            <div class="product-info" :class="{'text-left' : rtl == false, 'text-right' : rtl == true}">
                                <h3 class="text-truncate name"><a
                                        :href="product.url">{{ product.product_name[lang]  ? product.product_name[lang] : product.product_name[fallbacklang] }}</a>
                                </h3>


                                <div v-if="product.rating != 0"
                                    :class="{'pull-left' : rtl == false, 'pull-right' : rtl == true}">
                                    <div class="star-ratings-sprite"><span :style="{ 'width' : `${product.rating}%` }"
                                            class="star-ratings-sprite-rating"></span></div>
                                </div>

                                <div v-else class="no-rating">No Rating</div>

                                <!-- Product-price -->

                                <div v-if="guest_price == '0' || login == 1" class="product-price">
                                    <span class="price">

                                        <div v-if="product.offer_price != ''">
                                            <span class="price">
                                                <i v-if="product.position == 'l' || product.position == 'ls'"
                                                    :class="product.symbol"></i>
                                                <span v-if="product.position == 'ls'">&nbsp;</span>

                                                {{ product.offer_price }}

                                                <span v-if="product.position == 'rs'">&nbsp;</span>
                                                <i v-if="product.position == 'r' || product.position == 'rs'"
                                                    :class="product.symbol"></i>

                                            </span>
                                        </div>


                                        <div v-else>
                                            <span class="price">
                                                <i v-if="product.position == 'l' || product.position == 'ls'"
                                                    :class="product.symbol"></i>
                                                <span v-if="product.position == 'ls'">&nbsp;</span>

                                                {{ product.offer_price }}

                                                <span v-if="product.position == 'rs'">&nbsp;</span>
                                                <i v-if="product.position == 'r' || product.position == 'rs'"
                                                    :class="product.symbol"></i>
                                            </span>
                                            <span class="price-before-discount">
                                                <i v-if="product.position == 'l' || product.position == 'ls'"
                                                    :class="product.symbol"></i>
                                                <span v-if="product.position == 'ls'">&nbsp;</span>

                                                {{ product.price }}

                                                <span v-if="product.position == 'rs'">&nbsp;</span>
                                                <i v-if="product.position == 'r' || product.position == 'rs'"
                                                    :class="product.symbol"></i>
                                            </span>
                                        </div>

                                    </span>
                                </div>

                                <!-- /.product-price -->

                            </div>
                            <div v-if="product.stock != 0"  class="cart clearfix animate-effect">
                                <div class="action">
                                    <ul class="list-unstyled">

                                        <!-- cart condition -->

                                        <li v-show="guest_price == '0' || login == 1" id="addCart" class="lnk wishlist">

                                            
                                            <button :title="translate('staticwords.View')" type="submit"
                                                class="addtocartcus btn"><i class="fa fa-eye"></i>
                                            </button>
                                            

                                        </li>

                                       
                                    </ul>
                                </div>
                                <!-- /.action -->
                            </div>

                            <!-- /.cart -->
                        </div>
                        <!-- /.product -->

                    </div>
                    <!-- /.products -->
                </div>
                <!-- /.item -->
            </div>


        </div>
        <div v-else>
            <slider-skelton :item="6"></slider-skelton>
        </div>




        <!-- /.home-owl-carousel -->
    </section>
</template>

<script>
    axios.defaults.baseURL = baseUrl;
    export default {
        data() {
            return {
                products: [],
                lang: '',
                fallbacklang: '',
                loading: true,
                rtl : rtl,
                guest_price : '',
                login : ''
            }
        },
        methods : {
            installOwlCarousel(rtl) {
                
                $('.home-owl-carousel').each(function () {

                    var owl = $(this);

                    var itemPerLine = owl.data('item');

                    if (!itemPerLine) {
                        itemPerLine = 4;
                    }
                    owl.owlCarousel({
                        items: 3,
                        itemsTablet: [978, 1],
                        itemsDesktopSmall: [979, 2],
                        itemsDesktop: [1199, 1],
                        nav: true,
                        rtl: rtl,
                        slideSpeed: 300,
                        margin: 10,
                        pagination: false,
                        lazyLoad: true,
                        navText: ["<i class='icon fa fa-angle-left'></i>",
                            "<i class='icon fa fa-angle-right'></i>"
                        ],
                        responsiveClass: true,
                        responsive: {
                            0: {
                                items: 3,
                                nav: false,
                                dots: false,
                            },
                            600: {
                                items: 3,
                                nav: false,
                                dots: false,
                            },
                            768: {
                                items: 4,
                                nav: false,
                            },
                            1100: {
                                items: 5,
                                nav: true,
                                dots: true,
                            }
                        }
                    });
                });
            },

            createOwl() {

                var vm = this;

                this.$nextTick(() => {
                 vm.installOwlCarousel(this.rtl);
                });
                

            }
        },
        mounted() {
            axios.get('/vue/d-products').then(res => {
                this.products = res.data.products;
                this.lang = res.data.lang;
                this.fallbacklang = res.data.fallback_locale;
                this.login = res.data.logged_in;
                this.guest_price = res.data.guest_price;
                this.loading = false;

                 this.createOwl();

            }).catch(err => console.log(err));
        }

    }
</script>