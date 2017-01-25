<template>

  <div>
    <transition :name='transitionName' mode='out-in'>
      <router-view class='child-view'></router-view>
    </transition>
  </div>

</template>

<script>
  export default {
    data(){
      return {
        transitionName: 'slide-left',
      }
    },
    watch: {
      '$route' (to, from) {
        const toDepth = to.path.split('/').length
        const fromDepth = from.path.split('/').length  
        this.transitionName = toDepth < fromDepth ? 'slide-right' : 'slide-left'
      }
    }
  }
</script>

<style lang="less">
/*App.vue*/
  @import '~vux/src/styles/reset.less';

  /*body {
    background-color: #fbf9fe;
  }*/
  body{
    background-color:#F6F6F6;
  }

  ul {
    list-style: none;
  }
  body,header,footer,section,div,span,p,img,a,ul,li,dl,dt,dd,h1,h2,h3,h4,h5,h6,em,i,b,u,del,button,input,textarea{padding:0;margin:0;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;-o-user-select:none;user-select:none;-webkit-touch-callout:none;-webkit-text-size-adjust:none;-webkit-tap-highlight-color:rgba(0,0,0,0);font-family:Microsoft Yahei,Helvetica,Arial;}
input,textarea{-webkit-user-select:auto !important;}
:focus{outline:none;}
img{vertical-align:middle;border:0 none;}
ul{list-style:none;}
a{text-decoration:none;}
section{margin:0 auto;}
header,footer{margin:0 auto;width:100%;}
em,i{font-style:normal;}
input{outline:none;}
html,body{width:100%;height:100%;}
button,input{border:0 none;}

/*重置mintui的样式*/
.mint-field-core{
  background: transparent;
}
.mint-cell-wrapper{
  background: transparent;
  
}

.mint-cell{
  min-height: 100%;
}
.mint-header-title{
  font-size:1rem
}
input{
  font-family: Microsoft Yahei,Helvetica,Arial;
}
a{text-decoration:none;color:inherit;}

</style>
