<template>
  <div>
    <router-view></router-view>
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
import { Badge} from 'vux'

  export default {
    components: {Badge},
    data(){
      return {
        selected: 'home',
        isLogin:false,
        cartlistCount:0,
        isShow:true
      }
    },
    methods:{
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
      }
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
    created(){
      let path=this.$route.path;
      if(path.indexOf('home')!==-1){
            this.selected='home'
          }else if(path.indexOf('nearby')!==-1){
            this.selected='nearby'
          // }
          // else if(path.indexOf('cart')!==-1){
          //   this.selected='cart'
          }else if(path.indexOf('personCenter')!==-1){
            this.selected='personCenter'
          }
          // if(path.indexOf('cart')!==-1){
          //   this.isShow=false;
          // }else{
          //   this.isShow=true;
          // }
          this.init();
      }


  }
</script>

<style lang="less">

  ul {
    list-style: none;
  }

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
</style>
