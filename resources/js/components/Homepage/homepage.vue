<template>

    <div>

       <Ads :position="'beforeslider'"/>
        
       <slider></slider>

       <Ads :position="'abovenewproduct'"/>

       <mobile-view v-if="tabbed_products" :date="date" :lang="lang" :fallbacklang="fallbacklang" :login="logged_in" :guest_price="guest_price" :top_products="top_products" :products="tabbed_products" :featuredproducts="featuredproducts" :featured_simple_producrs="simple_products" :mob_simple_products="simple_tabbed_products"></mobile-view>

       <new-products-d v-if="!loading" :simple_tabbed_product="simple_tabbed_products" :tabbed_products="tabbed_products" :tabbed_cats="tabbed_cats" :date="date" :lang="lang" :fallbacklang="fallbacklang" :login="logged_in" :guest_price="guest_price"></new-products-d>

       <div v-else>
            
            <slider-skelton :item="6"></slider-skelton>
            
       </div>

       
       <Ads :position="'abovelatestblog'"/>
      
       <blogslider></blogslider>

        <Ads :position="'abovetopcategory'"/>

       <top-products-d v-if="!loadingfortopproducts" :date="date" :lang="lang" :fallbacklang="fallbacklang" :login="logged_in" :guest_price="guest_price" :top_products="top_products"></top-products-d>
       <div v-else>
            <div v-for="i in 2" :key="i">
                <slider-skelton :item="6"></slider-skelton>
            </div>
       </div>

       <Ads :position="'abovefeaturedproduct'"/>

       <featured-products v-if="!loadingforfeatured" :date="date" :lang="lang" :fallbacklang="fallbacklang" :login="logged_in" :guest_price="guest_price" :products="featuredproducts" :simple_products="simple_products"></featured-products>

       <Ads :position="'afterfeaturedproduct'"/>
       
    </div> 
   
</template>
<script>
    axios.defaults.baseURL = baseUrl;

    import Ads from '../Advertise/Advertise';

    export default {
        components : {
            Ads
        },
        data() {
            return {
                featuredproducts : [],
                simple_products : [],
                lang : '',
                fallbacklang : '',
                date : '',
                rtl : rtl,
                guest_price : '',
                logged_in : '',
                tabbed_products : [],
                tabbed_cats : [],
                simple_tabbed_products : [],
                top_products : [],
                loadingforfeatured : true,
                loadingfortopproducts : true,
                loading : true
            }
        },
        methods : {
          async getHomepage(){
             await axios.get('/homepage')
                  .then((res) => {
                      this.lang = res.data.lang;
                      this.fallbacklang = res.data.fallback_local;
                      this.featuredproducts = res.data.featuredproducts;
                      this.simple_products = res.data.simple_featuredproducts;
                      this.guest_price = res.data.guest_price;
                      this.date = res.data.date;
                      this.logged_in = res.data.logged_in;
                      this.loadingforfeatured = false;

              })
              .catch(err => console.log(err));
          },

          async loadtopcategoryproducts(){
              await axios.get('/vue/top/category/products').then(res => {

                  this.top_products = res.data;

                  this.loadingfortopproducts = false;

                  console.log(res.data);

              }).catch(err => console.log(err));
          },

          async loadtabbedproducts(){
              await axios.get('/vue/tabbed/products').then(res => {

                  
                      this.tabbed_products = res.data.all.products;
                      this.simple_tabbed_products = res.data.all.simple_products;
                      this.tabbed_cats = res.data.cats;
                      this.loading = false;

                      console.log(this.simple_tabbed_products);

              }).catch(err => console.log(err));
          }
        },
        created() {
            
            this.getHomepage();
            this.loadtabbedproducts();
            this.loadtopcategoryproducts();
            
        }
    }
</script>