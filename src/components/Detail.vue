<template>
  <div>
    <MyHeader bgcolor='#fff' fontcolor='#000' borderbottom='1px solid #ddd' title='商品详情'></MyHeader>
    <swiper  loop auto :interval='interval' dots-position="center" :list="imgList"
            :aspect-ratio='375/400' :index="carousel_index"
            @on-index-change="carousel_onIndexChange"></swiper>
    <div class="detail j_detail">

      <article>{{bookDetail.name}}</article>
      <div class="product_subname" style="-webkit-line-clamp: 3;">
        {{bookDetail.introduction}}
      </div>
      <a class="promo_title" style="text-decoration: underline;" @click='notDev'>&gt;30万图书满300立减100&gt;&gt;&gt;</a>
      <div></div>

      <div class="left two">
        <b>¥<span id="main_price">{{bookDetail.newprice}}</span></b>
        <div class="original_price">
          <em class="discount">
            {{discount}}折 </em>

          <span>定价：</span>
          <del>{{bookDetail.oldprice}}</del>

        </div>
        <aside>

          <span class="" style="background:#ff5753;">当当自营</span>


          <span class="j_second_promo_icon" style="background-color:;  display:none;">
							</span>


        </aside>
      </div>


      <div class="ensure">
        <ul class="j_product_info">


          <li class="icon_support">当当发货&amp;售后</li>


          <li class="icon_support">正品保障</li>


          <li class="icon_support">7天退换</li>


          <li class="icon_support">支持礼品卡</li>


          <li class="icon_support">货到付款</li>

        </ul>
      </div>
    </div>
    <section class="jump linkto_author_bang">

      <a class="arrow_con">
        <div class="arrow link_line">
          <span class="linkto_name">作者</span>
          <span class="linkto_value">
                {{bookDetail.author}}            </span>

        </div>
      </a>
      <a class="arrow_con">
        <div class="arrow link_line">
          <span class="linkto_name">出版</span>
          <span class="linkto_value">{{bookDetail.publish}}</span>

        </div>
      </a>

    </section>
    <MyCount :min='1' :max='200' style='margin-top:0;margin-bottom:0.25rem;font-size:16px;' v-model='book_count'></MyCount>
    <section class="jump">
      <a class="arrow_con">
        <div class="arrow">
          <h4>商品评论（{{bookDetail.comment}}）</h4>
          <em></em>
        </div>
      </a>
    </section>
    <a class="jump banner_block" href='javascript:void(0)'>
      <img class="" src="../assets/730x220_dl_20170111.jpg">
    </a>
    <section class="hot">
      <h4>推广商品<i>广告</i></h4>
      <ul>
        <li v-for='item in advertisement'>
          <router-link :to="{path:'/main/home/detail/'+item.bid}">
            <img :src="'/static/img/'+item.img_sm">
            <span>{{item.name}} {{item.introduction}}</span>
            <em>¥{{item.newprice}}</em>
          </router-link>
        </li>
      </ul>
    </section>
    <section class="shopping_cart">

      <div class="btn_fav_cart">
        <div class="fav" :class="{on:isfav}" style="width:50%; ">
          <a @click='fav'>收藏</a>
        </div>
        <router-link to="/main/cart" class="cart" style="width:50%; min-width:initial;">
          <span><i v-show='cartlistCount==0?false:true'>{{cartlistCount}}</i></span>
          <p class="cart_name">购物车</p>
        </router-link>


      </div>
      <div class="btn_con">
        <button class="buy J_buy" @click='buy'>立即购买</button>
        <button class="add" @click='addItem'>加入购物车</button>
      </div>

    </section>
  </div>
</template>
<script>
  import {Swiper, SwiperItem} from 'vux'
  import MyHeader from './Header.vue'
  import {Toast,Indicator} from 'mint-ui'
  import MyCount from './CountNum.vue'
  export default {
    components: {
      MyHeader,
      Swiper,
      SwiperItem,
      MyCount
    },
    data(){
      return {
        carousel_index: 0,
        interval: 4000,
        isfav: false,
        bookDetail: [],
        img_lg: [],
        advertisement: [],
        isLogin:false,
        cartlistCount:0,
        bid:'',
        book_count:1
      }
    },
    computed: {
      discount(){
        return (this.bookDetail.newprice / this.bookDetail.oldprice * 10).toFixed(1);
      },
      imgList(){
        let imgList = (this.img_lg);
        const list = imgList.map((val, index) => ({
          url: 'javascript:',
          img: `/static/img/${val}`
        }));
        return list;
      }
    },
    methods: {
      carousel_onIndexChange (index) {
        this.carousel_index = index
      },
      notDev(){
        Toast({
          message: '年轻人别着急，还在开发中呢！',
          position: 'bottom',
          duration: 3000
        });
      },
      fav(){
        this.isfav = !this.isfav;
        if (this.isfav) {
          Toast({
            message: '加入收藏成功',
            position: 'bottom',
            duration: 1000
          });
        } else {
          Toast({
            message: '取消收藏成功',
            position: 'bottom',
            duration: 1000
          });
        }
      },
      fetchData(){
        this.bid=this.$route.params.id;
        let id = this.$route.params.id;
        let _this = this;
        // this.$http.get('bookdetail.php?id=' + id).then(function (res) {
        this.$http.get('bookdetail?bid=' + id).then(function (res) {
          //console.log(res);
          _this.bookDetail = res.data;
          _this.img_lg = res.data.img_lg.split(';')
        }).catch(function (err) {
          console.log(err);
        });
        this.$http.get('advertisement?bid=' + id).then(function (res) {
          _this.advertisement = res.data;
        }).catch(function (err) {
          console.log(err);
        });
      },
      init(){
        let _this=this;
        if(this.getCookie('BOOK_user_uid')!==null){
            this.isLogin=true;
            let uid=this.getCookie('BOOK_user_uid');
            this.$http.get('cartlistCount.php?uid='+uid).then(function (res) {
              _this.cartlistCount=res.data.count;
            }).catch(function (err) {
              console.log(err);
            });
          }
      },
      addItem(){
        let bid=this.bookDetail.bid;
        let uid=this.getCookie('BOOK_user_uid');
        let _this=this;
        if(this.isLogin==false){
          this.$router.push('/login');
        }else{
            this.$http.get('addItem.php?bid='+bid+'&uid='+uid).then(function (res) {
              if(res.data.msg=='succ'){
                Toast({
                  message: '加入购物车成功',
                  duration: 2000
                });
                _this.cartlistCount=res.data.total;
              }
            }).catch(function (err) {
              console.log(err);
            });
        }
      },
      buy(){
        let bid=this.bookDetail.bid;
        let uid=this.getCookie('BOOK_user_uid');
        let count=this.book_count;
        let _this=this;
        if(this.isLogin==false){
          this.$router.push('/login');
        }else{
          Indicator.open({
            text: '加载中...',
            spinnerType: 'fading-circle'
          });
            this.$http.get('order.php?bid='+bid+'&uid='+uid+'&count='+count).then(function (res) {
              if(res.data.msg=='succ'){
                Indicator.close();
                _this.$router.push('/main/home/order');
              }
            }).catch(function (err) {
              console.log(err);
            });
        }
      }
    },
    created(){
      this.fetchData();
      this.init();
    },
    watch: {
      $route(){
        this.fetchData();
      }
    }
  }
</script>
<style>
    /* 热卖商品 */
  .hot {
    padding: .5rem .375rem .5rem .5rem;
    background-color: white;
    padding-bottom: 60px;
    border-bottom: 1px solid #ddd;
    border-top: 1px solid #ddd;
  }

  .hot h4 {
    color: #4d525d;
    font-size: .9rem;
    line-height: 1.2rem;
    font-weight: normal;
    padding-bottom: .5rem;
  }

  .hot h4 i {
    float: right;
    height: .8rem;
    background: rgba(204, 204, 204, .8);
    font-size: .6rem;
    line-height: .8rem;
    padding: 0 .1rem;
    color: white;
    min-width: 1rem;
    text-align: center;
    margin-top: .3rem;
  }

  .hot .title_con {
    position: relative;
    display: block;
    height: .8rem;
    text-align: center;
    margin-bottom: .4rem;
    font-size: 0;
  }

  .hot .title_con .title {
    font-size: .6rem;
    display: inline-block;
    line-height: .8rem;
    background-color: #eee;
    padding: 0 1.25rem;
    position: relative;
    z-index: 2;
    vertical-align: top;
    color: #969696;
  }

  .hot .title_con .line {
    height: 0;
    font-size: 0;
    line-height: 0;
    border-bottom: 1px solid #ccc;
    position: absolute;
    top: .4rem;
    left: 0;
    width: 100%;
    z-index: 1;
  }

  .hot ul {
    overflow: hidden;
  }

  .hot ul li {
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    float: left;
    width: 50%;
    padding-left: 0;
    padding-right: .25rem;
    margin-bottom: .25rem;
  }

  .hot ul li:nth-child(2n) {
    padding-left: .25rem;
    padding-right: 0;
  }

  .hot ul li a {
    display: block;
    background-color: white;
    overflow: hidden;
    padding-bottom: .375rem;
  }

  .hot ul li a img {
    display: block;
    width: 100%;
    height: auto;
  }

  .hot ul li a span {
    border-top: 1px solid #f2f2f2;
    color: #464646;
    padding: .25rem .25rem 0 .25rem;
    margin-bottom: .25rem;
    font-size: .65rem;
    line-height: .9rem;
    height: 1.8rem;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
    overflow: hidden;
    text-overflow: ellipsis;
    border-top: 1px solid #f2f2f2;
  }

  .hot ul li a em {
    display: inline-block;
    color: #ff463c;
    font-size: .75rem;
  }

  .hot ul li a del {
    display: inline-block;
    color: #969696;
    font-size: .6rem;
    text-decoration: line-through;
  }
</style>
<style scoped>
  /*detail.vue*/
  .child-view {
    background-color: #e8e8e8;
  }

  /* detail */
  .ellipsis {
    display: block;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .detail {
    border-top: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
    margin-bottom: .25rem;
    background-color: white;
    padding-top: .5rem;
    position: relative;
  }

  .detail .left {
    margin-right: 3.5rem;
    margin-left: .5rem;
    min-height: 1.3rem;
    overflow: hidden;
    white-space: nowrap;
  }

  .detail .left b {
    color: rgb(255, 129, 97);
    font-size: 1rem;
    line-height: 1rem;
    margin-right: .25rem;
  }

  .left .original_price {
    color: rgb(150, 150, 150);
    font-size: 0.6rem;
    line-height: 1.2rem;
  }

  .left .discount {
    margin-right: 0.5rem;
  }

  .detail .left del {
    text-decoration: line-through;
  }

  .detail .left em {
    display: inline-block;
  }

  .detail .left aside, .presell_section aside {
    padding-top: .1rem;
    padding-bottom: .5rem;
  }

  /* 标签 */
  aside {
    clear: both;
    overflow: hidden;
    display: block;
    font-size: 0;
    line-height: 0;
  }

  aside span {
    display: inline-block;
    color: white;
    margin-right: .2rem;
    padding: 0 .2rem;
    border-radius: .1rem;
    line-height: 1rem;
    font-size: .55rem;
  }

  aside span.red {
    background-color: #fe435d;
  }

  aside span.blue {
    background-color: #67c9e2;
  }

  aside span.orange {
    background-color: #ff6c00;
  }

  aside span.purple {
    background-color: #8970bd;
  }

  aside span.phone {
    background-color: #31afff;
  }

  aside span.earth {
    text-indent: .65rem;
  }

  /*详细*/
  .detail article {
    display: -webkit-box;
    margin: .25rem .5rem .2rem .5rem;
    font-size: .9rem;
    color: #4d525d;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
    overflow: hidden;
    text-overflow: ellipsis;
    word-break: break-all;
  }

  .detail article.last {
    margin-bottom: .5rem;
  }

  .detail p {
    display: block;
    padding-top: .2rem;
    padding-bottom: .25rem;
    margin-left: .5rem;
    margin-right: .5rem;
    color: #5f646e;
    font-size: .6rem;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    line-height: .8rem;
  }


  .detail .product_subname {
    margin: .25rem .5rem .2rem .5rem;
    line-height: 1rem;
    color: rgb(150, 150, 150);
    font-size: .6rem;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    word-break: break-all;
  }

  .detail .promo_title {
    display: block;
    margin: -0.2rem .5rem .5rem .5rem;
    font-size: .55rem;
    color: rgb(255, 70, 60);
  }

  /* 保障 */
  .ensure {
    padding: .55rem .5rem 0 .5rem;
    border-top: 1px dashed #ddd;
    background-color: #fffaf6;
  }

  .ensure ul {
    overflow: hidden;
    color: #4d525d;
    font-size: .55rem;
  }

  .ensure ul li {
    float: left;
    display: block;
    margin-right: .75rem;
    text-indent: .875rem;
    background-repeat: no-repeat;
    background-position: left center;
    background-size: contain;
    height: .8rem;
    line-height: .8rem;
    margin-bottom: .55rem;
  }

  .ensure ul li:last-child {
    margin-right: 0;
  }

  .ensure ul li.icon_support {
    background-image: url('../assets/icon_baozhang.png');
    background-size: 0.66rem 0.66rem;
    background-position: 0rem 0rem;
  }

  /* 通用跳转 */
  .jump {
    border-top: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
    margin-bottom: .25rem;
    background-color: white;
  }

  .jump h4 {
    color: #4d525d;
    font-size: .9rem;
    line-height: 1.2rem;
    font-weight: normal;
    float: left;
  }

  .jump h4 span {
    display: inline-block;
    margin-left: .5rem;
    color: #969696;
  }

  .jump h4 span i {
    color: #fe435d;
  }

  .jump em {
    color: #969696;
    font-size: .55rem;
    height: .8rem;
    line-height: 1.2rem;
    float: right;
    display: inline-block;
    margin-right: .75rem;
  }

  .linkto_author_bang a {
    margin: 0 0.5rem;
    padding: 0.5rem 0;
    border-bottom: 1px solid rgb(223, 223, 223);
    clear: both;
  }

  .linkto_author_bang a:last-child {
    border-bottom: 0;
  }

  .linkto_author_bang .link_line {
    color: #4d525d;
    font-size: .9rem;
    line-height: 1.2rem;
    font-weight: normal;
  }

  .arrow .linkto_name {
    color: #969696;
    display: block;
    float: left;
    width: 15%;
    padding-left: 2%;
  }

  .arrow .linkto_value {
    display: block;
    float: left;
    width: 55%;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
  }

  .arrow .linkto_look {
    color: #969696;
    display: block;
    float: left;
    text-align: right;
    width: 20%;
    font-size: 0.65rem;
  }

  .arrow .linkto_value .bang_rank {
    color: rgb(255, 129, 97);
  }

  .arrow .category_text {
    width: 75%;
  }

  /* 箭头 */
  .arrow_con {
    display: block;
    padding: .5rem;
    line-height: 1.2rem;
  }

  .arrow_con > * {
    overflow: hidden;
  }

  .arrow, .arrow_d {
    display: block;
    background-position: right center;
    background-color: white;
    background-repeat: no-repeat;
    background-size: .8rem .8rem;
  }

  .arrow {
    background-image: url('../assets/jump_arrow.png');
  }

  .banner_block {
    display: block;
    width: 100%;
    overflow: hidden;
  }

  .banner_block img {
    width: 100%;
  }



  /*购物车*/
  .shopping_cart {
    position: fixed;
    bottom: 0;
    left: 0;
    height: 2.55rem;
    width: 100%;
    border-top: 1px solid rgba(229, 229, 229, 0.93);
    background-color: rgb(255, 255, 255);
    z-index: 2;
  }

  .shopping_cart .btn_fav_cart {
    width: 38%;
    height: 2.25rem;
    text-align: center;
    font-weight: normal;
    font-size: .6rem;
    color: #4d525d;
  }

  .shopping_cart .fav {
    width: 50%;
    height: 100%;
    float: left;
  }

  .shopping_cart .fav a {
    display: block;
    width: 100%;
    height: .8rem;
    margin-top: 0.3rem;
    padding-top: 1.2rem;
    line-height: .8rem;
    background-position: center .125rem;
    background-repeat: no-repeat;
    background-size: 1rem 1rem;
    background-image: url('../assets/fav.png');
  }

  .shopping_cart .fav.on a {
    background-image: url('../assets/fav_on.png');
  }

  .shopping_cart .cart, .shopping_cart .robot {
    width: 40%;
    min-width: 2.75rem;
    height: 2.55rem;
    float: left;
  }

  .shopping_cart .cart span, .shopping_cart .robot span {
    display: block;
    position: relative;
    width: 1rem;
    height: 1rem;
    margin: 0 auto;
    margin-top: 0.4rem;
    margin-bottom: 0.1rem;
    text-indent: -99rem;
    background: url('../assets/icon_shoppingcart.png') center center no-repeat;
    background-size: 1rem 1rem;
  }

  .shopping_cart .cart span i, .shopping_cart .robot span i {
    display: block;
    position: absolute;
    top: -0.3rem;
    left: .65rem;
    min-width: 1rem;
    height: 1rem;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    border: .05rem solid white !important;
    border-radius: .4rem;
    background-color: #fe435d;
    color: white;
    font-size: .7rem;
    line-height: .7rem;
    text-indent: 0;
    text-align: center;
    padding: 0 .125rem;
  }

  .shopping_cart .cart .cart_name, .shopping_cart .robot .robot_name {
    height: 0.8rem;
    line-height: 0.8rem;
  }

  .shopping_cart .btn_fav_cart {
    width: 38%;
    height: 100%;
    float: left;
  }

  .shopping_cart .btn_con {
    width: 62%;
    height: 100%;
    float: left;
  }

  .shopping_cart .btn_con button {
    display: block;
    float: left;
    height: 100%;
    line-height: 2.55rem;
    font-size: 0.75rem;
    text-align: center;
    color: white;
  }

  .shopping_cart .btn_con .baby_book_buy {
    display: block;
    float: left;
    height: 100%;
    line-height: 2.55rem;
    font-size: 0.75rem;
    text-align: center;
    color: white;
  }

  .shopping_cart .btn_con .buy {
    width: 50%;
    height: 100%;;
    background-color: rgba(250, 180, 90, 0.93);
  }

  .shopping_cart .btn_con .big {
    width: 100%;
    background-color: rgba(249, 79, 75, 0.93);
  }

  .shopping_cart .btn_con .notsupport {
    width: 100%;
    background-color: rgba(150, 150, 150, 0.93);
  }

  .shopping_cart .btn_con .add {
    width: 50%;
    height: 100%;
    background: -webkit-linear-gradient(left, rgba(253, 132, 89, 0.93), rgba(247, 86, 82, 0.93)); /* Safari 5.1 - 6.0 */
    background: -o-linear-gradient(right, rgba(253, 132, 89, 0.93), rgba(247, 86, 82, 0.93)); /* Opera 11.1 - 12.0 */
    background: -moz-linear-gradient(right, rgba(253, 132, 89, 0.93), rgba(247, 86, 82, 0.93)); /* Firefox 3.6 - 15 */
    background: linear-gradient(to right, rgba(253, 132, 89, 0.93), rgba(247, 86, 82, 0.93));
  }

</style>
