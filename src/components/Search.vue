<template>
	<div>
		 <!-- <search ref='my' @on-change="getResult"  v-model="value" @on-cancel='back'></search> -->
		 <div class="vux-search-box vux-search-fixed" style="top: 0px;">
		  <div id="search_bar" class="weui_search_bar weui_search_focusing" ref='searchClick'>
		    <form class="weui_search_outer">
		      <div class="vux-search-mask" style="display: none;"></div>
		      <div class="weui_search_inner"><i class="weui_icon_search"></i> 
		      <input ref='my' type="search" id="search_input" autofocus autocomplete="off" v-model='value' class="weui_search_input"> 
		      <a href="javascript:" id="search_clear" class="weui_icon_clear" @click="clear"></a></div>
		      <label for="search_input" id="search_text" class="weui_search_text"><i class="weui_icon_search"></i>
		        <span>搜索</span></label></form>
		    <a href="javascript:" id="search_cancel" class="weui_search_cancel" @click='back'>取消</a></div>
		  <div id="search_show" class="weui_cells weui_cells_access vux-search_show"></div>
		</div>
		<div class="hot-search" v-if="hotSearch" >
        <p>热门搜索</p>
        <ul>
            <li v-for="item in hotlist">
            <router-link :to="{path:'/main/home/detail/'+item.bid}">{{item.name}}</router-link>
        </ul>
    </div>
		 <ul class="bookList_ul j_bookList_ul" style='padding-top:70px;' v-show='!hotSearch'>
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
	</div>
</template>
<script>
	import { Search} from 'vux'
	export default{
		data(){
			return {
				disabled:true,
				userName:'',
				userPwd:'',
				err:false,
				value:'',
				book_list: [],
				hotSearch:true,
				hotlist:[]
			}
		},
		components:{
			Search
		},
		methods:{
			clear () {
		      this.value = ''
		      // this.isFocus = true
		      this.setFocus()
		    },
		    setFocus(){
		    	this.$refs.my.focus();
		    },
			btnOn(){
				if(this.userName!==''&&this.userPwd!==''){
					this.disabled=false;
					this.err=false;
				}else{
					this.disabled=true;
				}
			},
			login(){
				//console.log(1);
				let postPwd=this.userPwd;
				this.userPwd='';
				let _this=this;
				this.$http.post('login.php',qs.stringify({phone:this.userName,upwd:postPwd}),{headers: {'Content-Type': 'application/x-www-form-urlencoded',},
				}).then(function(res){
					//console.log(res);
					if(res.data.msg=='succ'){
						Toast({
						  message: '登录成功',
						});
						_this.SetCookie('BOOK_user_phone',_this.userName);
						_this.SetCookie('BOOK_user_uid',res.data.uid);
						_this.$router.back();
					}else{
						Toast({
						  message: '手机号或密码错误',
						});
						_this.err=true;
					}
				}).catch(function(err){
					console.log(err);
					Toast({
						  message: '当前网络不给力请稍后重试',
						});
				})
			},
			getResult(){
				let _this=this;
				//console.log(val==undefined)
				
				if(this.value==''){
					this.hotSearch=true;
				}else{
					this.hotSearch=false;
					this.$http.get('book_getbykw.php?kw='+this.value).then(function(res){
					_this.book_list=res.data;
					//console.log(res);
				}).catch(function(err){
					console.log(err)
				})
			}
			},
			back(){
				this.$router.back();
			}
		},
		created(){
			let _this=this;
			this.$http.get('hot_search.php').then(function(res){
				//console.log(res.data.length)
				for(var i=0;i<res.data.length;i++){
		            if(res.data[i].name.indexOf("（")!==-1){
		                res.data[i].name=(res.data[i].name.split("（"))[0];
		            }
		         }
					_this.hotlist=res.data;
					//console.log(res);
				}).catch(function(err){
					console.log(err)
				})


		},
		mounted(){
			this.setFocus();
			
		},
		watch:{
			value(){
				this.getResult();
			}
		}
	}
</script>
<style>
/*login.vue*/
.weui_search_outer,.weui_search_cancel{
	font-size: 16px;
}

</style>
<style scoped>
	.hot-search{
    padding-left:0.5rem;
    padding-top: 50px;
}
.hot-search >p{
    font-size: .55rem;
    color: #646464;
    padding-left: 0.9rem;
    margin-top: 0.5rem;
    background: url('../assets/fire_icon.png') 0 center no-repeat;
    background-size: 1rem;
}
.hot-search ul li{
    display: inline-block;
    background: #ddd;
    padding: 0.5rem;
    border-radius: 5px;
    margin-right: 5px;
    max-width: 100%;
    margin-bottom:8px;
    /* border: 1px solid #ddd; */
}
.hot-search ul li a{
    display: block;
    margin: auto .65rem;
    height: 1.4rem;
    line-height: 1.4rem;
    font-size: .8rem;
    text-align: center;
    min-width: 2.45rem;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    color: #464646;
    text-decoration: none;
}
[contenteditable = "true"], input, textarea {
    -webkit-user- select: auto!important;
    -khtml-user-select: auto!important;
    -moz-user-select: auto!important;
    -ms-user-select: auto!important;
    -o-user-select: auto!important;
    user-select: auto!important;
}
</style>