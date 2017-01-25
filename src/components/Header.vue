<template>
<div> 

  <header class="my-header" :class="{ 'is-fixed': fixed }">
    <div class="my-header-button is-left">
      <a slot="left" @click='goBack'>
          <mt-button icon="back"></mt-button>
     </a>
    </div>
    <h1 class="my-header-title" v-text="title"></h1>
    <div class="my-header-button is-right">
      <slot name="right">
        <mt-button icon="more" @click='show' slot="right"></mt-button>
      </slot>
    </div>
    
    <ul class='header_shortcut' :class="{'show':showNav}" >
      <li class="shortcut_index">
        <router-link to='/main/home'>
          <span class='shortcut_home'></span>
          <strong>首页</strong>
        </router-link>
      </li>
      <li class="shortcut_index">
        <router-link to='/main/home/search'>
          <span class='shortcut_search'></span>
          <strong>搜索</strong>
        </router-link>
      </li>
      <li class="shortcut_index">
        <router-link to='/main/cart'>
          <span class='shortcut_cart'></span>
          <strong>购物车</strong>
        </router-link>
      </li>
      <li class="shortcut_index">
        <router-link to='/main/personCenter'>
          <span class='shortcut_per'></span>
          <strong>我的</strong>
        </router-link>
      </li>
    </ul>
 
  </header>
  <div class='auto' :class="{'hide':!showNav}"></div>
  </div>
</template>
<script>
	export default {
    data(){
      return {
      	back:'返回',
      	showBack:true,
        styleObject:{
          background:this.bgcolor,
          color:this.fontcolor,
          borderBottom:this.borderbottom
        },
        fixed:true,
        showNav:false
      }
    },
    props:['bgcolor','fontcolor','borderbottom','title'],
    methods:{
      goBack(){
        this.$router.back();
      },
      show(){
      this.showNav=!this.showNav
    }
    },
  }
</script>
<style scoped>
.header_shortcut strong{
  display: block;
    margin: 0 auto;
    color: #fff;
    font-weight: normal;
    font-size: 12px;
    line-height: 1;
}
.header_shortcut span{
  display: block;
  background: url('../assets/sprites.png') no-repeat;
  background-size: 450%;
  width: 25px;
  height: 25px;
    margin: 0 auto;
    margin-top: 6px;
    color: #fff;
    font-weight: normal;
    font-size: 12px;
    line-height: 1;
}
span.shortcut_search {
  background-position: -34px 0;
}
span.shortcut_home{
  background-position:1px 0;
}
span.shortcut_cart{
  background-position: -60px 0;
}
span.shortcut_per{
  background-position: -91px 0;
}
.header_shortcut li a{
  color: #fff;
  border: 0;
  font-size: 16px;
}
.header_shortcut li{
  width: 25%;
  float: left;
  text-align: center;
  display: none;
  transition: all linear .3s;
}
.header_shortcut.show li{
  display: block;
}
.auto{
  height: 90px;
  transition: all linear .3s;

}
.auto.hide{
  height: 40px;
}
.header_shortcut{
  position: absolute;
  top: 40px;
  left: 0;
  width: 100%;
  /* height: 50px; */
  height: 0;
  background: #404042;
  padding: 0;
  margin: 0;
  opacity: 0;
  /* display: none; */
  transition: all linear .3s;
}
.header_shortcut.show{
  height: 50px;
  opacity: 1;
  /* display: block; */
}
.my-header {
    -webkit-box-align: center;
        -ms-flex-align: center;
            align-items: center;
    /* background-color: #26a2ff; */
    background-color: #fff;
    box-sizing: border-box;
    color: #000;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    font-size: 16px;
    height: 40px;
    line-height: 1;
    padding: 0 10px;
    position: relative;
    text-align: center;
    white-space: nowrap;
}
.my-header .mint-button {
    background-color: transparent;
    border: 0;
    box-shadow: none;
    color: inherit;
    display: inline-block;
    padding: 0;
    font-size: inherit
}
.my-header .mint-button::after {
    content: none;
}
.my-header.is-fixed {
    top: 0;
    right: 0;
    left: 0;
    position: fixed;
    z-index: 1;
        border-bottom: 1px solid #ddd;
}
.my-header-button {
    -webkit-box-flex: .5;
        -ms-flex: .5;
            flex: .5;
}
.my-header-button > a {
    color: inherit;
}
.my-header-button.is-right {
    text-align: right;
}
.my-header-button.is-left {
    text-align: left;
}
.my-header-title {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    font-size: inherit;
    font-weight: 400;
    -webkit-box-flex: 1;
        -ms-flex: 1;
            flex: 1;
}
</style>