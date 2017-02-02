<template>
  <div class='home'>
    <div class='header' :class="{red:scrollBackground}" >
      <h2 class="logo"></h2>
      <div class="search" @click='toSearch'>
        <div class="search-content">
          <icon class='search-logo verCenter' type="search"></icon>
          <i class='search_logo vercenter'></i>
          <span class='context verCenter'>把好书带回家</span>
        </div>
      </div>
      <div class="login">
        <router-link to='/login' v-if='!isLogin'>登录</router-link>
        <router-link to='/main/personCenter' v-if='isLogin'>
          <i class='percenter_logo'></i>
        </router-link>
      </div>
    </div>
    <swiper loop auto :interval='interval' :list="carousel_list" :aspect-ratio='204/400' :index="carousel_index"
            @on-index-change="carousel_onIndexChange"></swiper>
    <div class="bookList_session"
         v-infinite-scroll="loadMore"
         infinite-scroll-disabled="loadingmore"
         infinite-scroll-distance="20"
         infinite-scroll-immediate-check='check'
    >
      <ul class="bookList_ul j_bookList_ul">
        <li class="book" v-for='(item,key) in book_list'>
          <router-link :to="{path:'/main/home/detail/'+item.bid}">
            <div class="book_main">
              <div class="book_img">
              <!-- <span class="book_index">{{key}}</span> -->
                <img class="" :src="'/static/img/'+item.img_sm"></div>
              <div class="book_contain">
                <p class="book_title textOverflow_hidden">
                  {{item.name}} </p>
                <p class="textOverflow_hidden">作者：
                  {{item.author}} </p>
                <p class="textOverflow_hidden">出版社：
                  {{item.publish}} </p>
                <p class="star_p">
                  <span class="red_star" v-for='i in Number(item.star)'></span>

                  <span class="comments_num">{{item.comment}}条评论</span>
                </p>
                <p>
                  <span class="now_price">¥{{item.newprice}}</span>
                  <span class="old_price">¥{{item.oldprice}}</span>
                </p>
              </div>
            </div>
            <!-- </a> -->
          </router-link>
        </li>
      </ul>

      <p class="page-infinite-loading" style='background-color:#fff;'  v-show='loading'>
        <mt-spinner type="double-bounce" color='rgb(38, 162, 255)'></mt-spinner>
        <span class='load-text'>加载中...</span>
      </p>
      <p class='load-tips' style='background-color:#fff;' v-show='moreDataCanBeLoaded'>没有更多数据可加载了...</p>
    </div>
    <mt-tabbar v-model="selected" :fixed='true' v-show='isShow'>
      <mt-tab-item id="home">
        <img slot="icon" src="../assets/tabicon1.png">
        主页
      </mt-tab-item>
      <mt-tab-item id="nearby">
        <img slot="icon" src="../assets/tabicon2.png">
        附近
      </mt-tab-item>
      <mt-tab-item id="cart" class='cart'>
      <mt-badge type="error" v-show='cartlistCount==0?false:true' size='small' class='cart_badge'>{{cartlistCount}}</mt-badge>
        <img slot="icon" src="../assets/tabicon3.png">
        购物车

      </mt-tab-item>
      <mt-tab-item id="personCenter">
        <img slot="icon" src="../assets/tabicon4.png">
        我的
      </mt-tab-item>
    </mt-tabbar>
  </div>
</template>

<script>
  import {Swiper, SwiperItem, Icon,Badge} from 'vux'
  import {Indicator} from 'mint-ui'

  import img1 from '../assets/carousel/700x270_gr_12151.png'
  import img2 from '../assets/carousel/1218-wx-y-700-270.jpg'
  import img3 from '../assets/carousel/700x270gift_lyx_1218.jpg'
  import img4 from '../assets/carousel/ebook12166720270.jpg'
  import img5 from '../assets/carousel/wuxian-shoujiao-H5.jpg'
  const imgList = [img1, img2, img3, img4, img5];
  const carousel_list = imgList.map((val, index) => ({
    url: 'javascript:',
    img: val
  }))
  export default {
    components: {
      Swiper,
      SwiperItem,
      Icon,
      Badge,
    },
    data () {
      return {
        // note: changing this line won't causes changes
        // with hot-reload because the reloaded component
        // preserves its current state and we are modifying
        // its initial state.
        carousel_index: 0,
        carousel_list: carousel_list,
        interval: 4000,
        scrollBackground: false,
        book_list: [],
        loading: false,
        moreDataCanBeLoaded: false,
        isLogin:false,
        loadingmore:false,
        selected: 'home',
        isLogin:false,
        cartlistCount:0,
        isShow:true,
        check:false,
        hotSearch:true,
        hotlist:[],
        showSearch:false
      }
    },
    computed: {
      // autoHeight(){

      // }
    },
    methods: {
      hideSearch(){
        this.showSearch=!this.showSearch;
      },
      carousel_onIndexChange (index) {
        this.carousel_index = index
      },
      getBookList(){
        let _this = this;
        Indicator.open({
            text: '加载中...',
            spinnerType: 'fading-circle'
          });
        this.$http.get('booklist.php').then(function (res) {
          if(res.data){
            Indicator.close();
          }else{
              
          }
          _this.book_list = res.data;
          //console.log(res.data)
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
      loadMore(){
        this.loading = true;
        let _this = this;
        let start = this.book_list.length;
          _this.$http.get('booklist.php?start=' + start).then(function (res) {
            if (res.data.length < 5) {
              _this.moreDataCanBeLoaded = true;
              _this.loadingmore=true;
            }
            if (res.data.length > 0) {
              _this.book_list = _this.book_list.concat(res.data);
            }
            _this.loading = false;
          }).catch(function (err) {
            console.log(err);
          });
      },
      toSearch(){
        this.$router.push("/main/home/search");
      },
      setFocus(){
        this.$refs.searchipt.focus();
      }
    },
    created: function () {
      let that = this;
      window.addEventListener('scroll', function () {
        if (this.scrollY > 100) {
          that.scrollBackground = true;
        } else {
          that.scrollBackground = false;
        }
      });
      this.getBookList();
      if(this.getCookie('BOOK_user_uid')!==null){
        this.isLogin=true;
      }
      this.init();
    },
     watch: {
      selected(val){
        switch (val) {
          case 'home':
            this.$router.push('/main/home');
            break;

          case 'nearby':
            this.$router.push('/main/nearby');
            break;

          case 'cart':
            this.$router.push('/main/cart');
            break;
          case 'personCenter':
            this.$router.push('/main/personCenter');
            break;
          default:
            // statements_def
            break;
        }
      },     
      $route(to){
          // console.log(to)
          if(to.path.indexOf('home')!==-1){
            this.selected='home'
          }else if(to.path.indexOf('nearby')!==-1){
            this.selected='nearby'
          // }
          // else if(to.path.indexOf('cart')!==-1){
          //   this.selected='cart';
          }else if(to.path.indexOf('personCenter')!==-1){
            this.selected='personCenter'
          }
          if(to.path.indexOf('cart')!==-1){
            this.isShow=false;
          }else{
            this.isShow=true;
          }
      }
    },
  }
</script>
<style>
.mint-tabbar > .mint-tab-item.is-selected {
    color: #e4393c;
    background-color: transparent;
  }
  .cart{
    position:relative;
  }
  .cart_badge{
    position:absolute;
    right:25px;
    top:5px;
  }
  /*书籍列表样式*/
  .bookList_session {
    display: block;
    width: 100%;
    background-color: #e8e8e8;
    /* margin-bottom: 55px; */
  }

  .bookList_ul li {
    width: 100%;
    margin-top: .25rem
  }

  .book_main {
    width: 100%;
    height: 7.56rem;
    background-color: #fff
  }

  .book_main .book_img {
    float: left;
    width: 33.3%;
    position: relative;
  }

  .book_main .book_index {
    background: rgb(255, 68, 51);
    color: rgb(255, 255, 255);
    font-size: 12px;
    padding: 0 0.2rem;
    line-height: 0.75rem;
    position: absolute;
    top: 0px;
    left: 0px;
  }

  .book_img img {
    max-width: 75%;
    max-height: 5.40rem;
    padding: 0.75rem 11.5% 0.75rem 13.5%;
  }

  .book_main .book_contain {
    float: left;
    width: 66.6%;
    padding: .35rem 0 .65rem 0;
    color: #a0a0a0;
    font-size: .6rem;
    line-height: 1.3rem
  }

  .book_title {
    color: #3f3f3f;
    font-size: 1rem;
    line-height: 1.2rem
  }

  .textOverflow_hidden {
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
  }

  .now_price {
    color: #f43
  }

  .old_price {
    text-decoration: line-through;
    margin-left: 0.2rem;
  }

  .phone_only {
    width: 3rem;
    height: 0.8rem;
    display: inline-block;
  }

  .book_description {
    width: 100%;
    height: 3.25rem;
    background-color: #f5f7f6
  }

  .book_description p {
    padding: .5rem .95rem;
    text-align: left;
    color: #a0a0a0;
    font-size: .7rem;
    line-height: 1.125rem;
    height: 1.9rem;
    overflow: hidden;
  }

  .book_contain p.star_p {
  }

  .book_contain .red_star {
    width: 0.8rem;
    height: 0.75rem;
    display: inline-block;
    vertical-align: middle;
    padding-bottom: 2px;
    background: url('../assets/red_star.png') no-repeat;
    background-size: 0.8rem 0.75rem;
  }

  .book_contain .gray_star {
    width: 0.8rem;
    height: 0.75rem;
    display: inline-block;
  }

  .comments_num {
    padding-left: 0.75rem;
  }
</style>
<style scoped>
/*home.vue*/
  .percenter_logo{
    display: inline-block;
    width: 40px;
    height: 44px;
    background: url('../assets/user_login.png') no-repeat center;
    background-size: 50%;
  }
  .carousel .vux-swiper {
    min-height: 204px;
  }
  .home{
    padding-bottom: 70px;
  }
  .header {
    box-sizing: border-box;
    width: 100%;
    position: fixed;
    top: 0;
    height: 44px;
    background: -webkit-linear-gradient(top, rgba(0, 0, 0, .7), rgba(0, 0, 0, 0));
    padding: 0 10px;
    z-index: 10;
    transition: background 0.3s linear;
  }

  .header.red {
    background: #e4393c;
  }

  .logo {
    position: absolute;
    left: 0;
    top: 0;
    height: 44px;
    width: 40px;
    background: url('../assets/dd-logo.png') center center no-repeat;
    background-size: 30px 21px;
    margin-left: 10px;

  }

  .search {
    position: relative;
    background: #fff;
    height: 100%;
    margin: 0px 50px;
    box-sizing: border-box;
    background-color: transparent;
  }

  .search:before {
    content: '';
    display: table;
  }

  .search-content {
    width: 100%;
    height: 30px;
    border-radius: 1rem;
    margin-top: 7px;
    background: rgba(255, 255, 255, 0.8);
    position: relative;
  }

  .search-logo {
    margin-left: 15px;
    font-size: 16px;
  }

  .verCenter {
    position: absolute;
    top: 50%;
    transform: translate(0, -50%);
  }

  .context {
    margin-left: 30px;
    color: #989191;
    font-size: 12px;
  }

  .login {
    position: absolute;
    right: 10px;
    top: 0;
    line-height: 44px;
    font-size: 16px;
  }

  .login a {
    color: #fff;
  }

  /* baoliu */

  .page-infinite-loading {
    text-align: center;
    height: 50px;
    line-height: 50px;
  }

  .page-infinite-loading span {
    display: inline-block;
    vertical-align: middle;
    margin-right: 5px;
  }

  .load-text {
    font-size: 12px;
  }

  .load-tips {
    text-align: center;
    font-size: 16px;
    color: #e4393c;
  }
  .weui_icon_search:before{
    position: absolute;
    transform: translate(-50%,-50%);
  }
</style>
