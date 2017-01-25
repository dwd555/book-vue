<template>
	  <div class='address_body'>
    <MyHeader  title='我的地址簿'></MyHeader>
    <section class="content">
        <ul class="checkout_address" style="">
                <li class="icon_ld border_top border_bottom" v-for='(item,key) in address'>
                    <div class="total">
                        <p class="content" >
                            <span class="bg">
                                <span class="name">{{item.name}}</span>
                                <span class="tel">            {{item.phone}}          </span>
                                <span class="detail">
                                    <em></em>
                                    <em>{{item.address}} </em>
                                </span>
                            </span>
                        </p>
                        <dl>
                            <dt class="chose" :class="{'po_mon':item.choose==5}" @click='selectAddr(item.aid)'>
                                默认地址                            </dt>
                            <dd class="ope_address">
                                <router-link :to="{path:'/main/personCenter/myAccount/address/editAddress'+item.aid}">
                                    <i>编辑</i>
                                </router-link>
                                <a @click='remove(item.aid)'><i>删除</i></a>
                            </dd>
                        </dl>
                    </div>
                </li>
                <li class="address_blank"></li>
            </ul>
    </section>
	<mt-button type="danger" size='large' style='position:fixed;bottom:0' @click='addAddress'>添加新地址</mt-button>
  </div>
</template>
<script>
	import MyHeader from './Header.vue'
	import { Group, XNumber } from 'vux'
	import {Toast,MessageBox} from 'mint-ui';
    import MyInput from './CountNum.vue'
    import qs from 'qs'
	export default{
		components:{
			MyHeader,
            MyInput
		},
		data(){
			return{
                address:[]
			}
		},
		methods:{
            init(){
                let uid=this.getCookie('BOOK_user_uid');
                let _this=this;
                this.$http.get('address.php?uid='+uid).then(function(res){
                    if(res.data!==null){
                        _this.address=res.data;
                    }

                }).catch(function(err){
                    console.log(err);
                })
            },
			addAddress(){
                this.$router.push('/main/personCenter/myAccount/address/addAddress');
            },
            selectAddr(aid){
                let _this=this;
                let uid=this.getCookie('BOOK_user_uid');
                this.$http.get('setAddressDefault.php?uid='+uid+'&aid='+aid).then(function(res){
                    if(res.data.msg=='succ'){
                        _this.init();
                    }
                }).catch(function(err){
                    console.log(err);
                })

            },
            remove(aid){
                let _this=this;
                MessageBox.confirm('确定删除该地址吗?').then(action => {
                  this.$http.get('removeAddress.php?aid='+aid).then(function(res){
                        if(res.data.msg=='succ'){
                            _this.init();
                        }
                    }).catch(function(err){
                        console.log(err);
                    })
                }).catch(function(res){
                    //console.log(res)
                });
            }
		},
		computed:{
			
		},
        created(){
            this.init()
        }

	}
</script>

<style scoped>
/* receive address */
.checkout_address{width:100%;}
.checkout_address .icon_ld{background-color:white;width:100%;padding-left:0;background-image:none;overflow:hidden;margin-top:6px;}
.checkout_address .icon_ld .total{width:100%;position:relative;overflow:hidden;}
.checkout_address .content{width:100%;line-height: 1rem;}
.checkout_address .content .bg{padding-left:0.85rem;display:block;}
.checkout_address p{color:#464646;}
.checkout_address p .name,.checkout_address p .tel{display:inline-block;font-size:0.9rem;margin-top: 0.25rem;}
.checkout_address p .name{float:left;margin-right:0.25rem;}
.checkout_address p .tel{float:right;margin-right:0.75rem;}
.checkout_address p .detail{clear:both;display:block;font-weight:normal;line-height:1rem;font-size:0.9rem;margin-bottom:0.25rem;padding:1rem 0;}
.checkout_address p .detail em{display:block;margin-right:0.75rem;}
.checkout_address p .detail em.small{line-height:1rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
/* checked */
.checkout_address .icon_ld.po_mon{background-image:none!important;}
.checkout_address .icon_ld.po_mon p.content{background:url(../assets/chosed_t.png) 1rem center no-repeat;background-size:1rem 1rem;}
/* handle */
.checkout_address .icon_ld.handle{background-color:rgb(250,250,250)!important;}
.checkout_address .icon_ld.handle .total{left:-45%;}
/* checked and handle */
/* edit delete */
.total dl{overflow:hidden;font-size:.9rem;color:#a0a0a0;border-top: 1px solid #e6e6e6;}
.total dl dt,.total dl dd{float:left;box-sizing:border-box;width:42%;height:1.75rem;line-height:1.75rem;}
.total dl dt{background: url(../assets/nochose.png) no-repeat 0.85rem center;background-size: 0.9rem 0.9rem;padding-left: 2rem;text-align: left;width: 54%}
.total dl i{display:inline-block;height:1.75rem;line-height:1.75rem;text-indent:1.1rem;font-style:normal;}
.total dl dd i{background:url(../assets/delete.png) left center no-repeat;background-size:0.95rem 0.95rem;}
.total dl dd.ope_address a:first-child i{background:url(../assets/edit.png) left center no-repeat;background-size:0.95rem 0.95rem;}
.total dl dd.ope_address a:last-child{margin-left: 1.5rem;}
.address_blank{font-size:0;height:0.3rem;line-height:0;clear:both;}





input:focus,textarea:focus{outline:none;}
.total dl dt.po_mon{background-image: url(../assets/chosed_t.png);}



</style>