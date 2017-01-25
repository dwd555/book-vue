<template>
    <div>
        <MyHeader  title='添加新地址'></MyHeader>
        <group label-width="4em" label-margin-right="2em" label-align="left">
          <x-input title="收货人" placeholder="必填" ref="input01" v-model='name' required :min="2" :max='10'></x-input>
          <x-input title="手&nbsp&nbsp&nbsp机" ref="input02" placeholder="必填" required keyboard="number" is-type="china-mobile" v-model='tel'></x-input>
          <x-input title="地&nbsp&nbsp&nbsp址" ref="input03"  placeholder="必填" v-model='address' :min="2" :max='128' required></x-input>
        </group>
        <group style='padding:0 1rem'>
        <mt-button type="danger" size='large' @click='save' >保存</mt-button>

        </group>
    </div>
</template>
<script>
	import MyHeader from './Header.vue'
	import { Group,XInput} from 'vux'
	import {Toast,MessageBox} from 'mint-ui';
	export default{
		components:{
			MyHeader,
            Group,
            XInput
		},
		data(){
			return{
                name:'',
                tel:'',
                address:''
			}
		},
		methods:{
			save(){
                let uid=this.getCookie('BOOK_user_uid');
                let _this=this;
                if(!this.$refs.input01.valid){
                    Toast({
                          message: '请输入正确的姓名',
                          duration:2000
                        });
                }else if(!this.$refs.input02.valid){
                    Toast({
                          message: '请输入正确手机号',
                          duration:2000
                        });
                }else if(!this.$refs.input03.valid){
                    Toast({
                          message: '请输入正确的地址信息',
                          duration:2000
                        });
                }
                if(this.$refs.input01.valid&&this.$refs.input02.valid&&this.$refs.input03.valid){
                    //console.log(this.name,this.tel,this.address);
                    this.$http.get('addAddress.php?uid='+uid+'&name='+this.name+'&phone='+this.tel+'&address='+this.address).then(function(res){
                        _this.$router.back();
                    }).catch(function(err){
                        console.log(err);
                    })
                }

            },
            
		},
		computed:{
			
		},
        created(){
            
        }

	}
</script>

<style scoped>

</style>