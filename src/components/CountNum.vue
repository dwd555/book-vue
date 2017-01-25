<template>
	<div class="weui_cells vux-no-group-title">
            <div class="weui_cell">
    <div class="weui_cell_bd weui_cell_primary">
      <p>数量</p>
    </div>
    <div class="weui_cell_ft" v-show="!readonly" style="font-size:0">
      <a @click="sub" class="vux-number-selector vux-number-selector-sub":class="{'vux-number-disabled':disabledMin}">-</a>
      <input @blur='checkNum' v-model.number="currentValue" :name="name" class="vux-number-input" :style="{width: width}" :readonly="!fillable"  type="text"/>
      <a @click="add" class="vux-number-selector vux-number-selector-plus" :class="{'vux-number-disabled':disabledMax}">+</a>
    </div>
    <div class="weui_cell_ft" v-show="readonly">
      {{value}}
    </div>
  </div>
          </div>
</template>
<script>
import {Toast} from 'mint-ui';
export default {
  props: {
    min: Number,
    max: Number,
    readonly: Boolean,
    step: {
      type: Number,
      default: 1
    },
    value: {
      type: Number,
      default: 1
    },
    name: String,
    title: String,
    fillable: {
      type: Boolean,
      default: true
    },
    width: {
      type: String,
      default: '50px'
    }
  },
  created () {
    this.currentValue = this.value
  },
  data () {
    return {
      currentValue: 0
    }
  },
  computed: {
    disabledMin () {
      return typeof this.min === 'undefined' ? false : this.currentValue <= this.min
    },
    disabledMax () {
      return typeof this.max === 'undefined' ? false : this.currentValue >= this.max
    }
  },
  watch: {
    currentValue (newValue, old) {
      // if (this.min && this.currentValue < this.min) {
      //   this.currentValue = this.min
      // }
      // if (this.max && this.currentValue > this.max) {
      //   this.currenValue = this.max
      // }
      // this.$emit('on-change', this.currentValue)
      // this.$emit('input', this.currentValue)
    },
    value (newValue) {
      this.currentValue = newValue
      this.$emit('on-change', this.currentValue)
    },
  },
  methods: {
    add () {
      if (!this.disabledMax) {
        this.currentValue += this.step;
        this.$emit('input', this.currentValue)
      }
    },
    sub () {
      if (!this.disabledMin) {
        this.currentValue -= this.step;
        this.$emit('input', this.currentValue)
      }
    },
    checkNum(){
       if(this.currentValue<1){
            this.currentValue=1;
        }else if(isNaN(this.currentValue)){
          //console.log(this.curerntValue)
              Toast({
                    message: '请输入数字！',
                           duration: 1000
                   });
                  this.currentValue=1;
        }else if(this.currentValue>200){
              Toast({
                  message: '超过数量限制！',
                    duration: 1000
                  });
             this.currentValue=200;
         }
      this.$emit('input', this.currentValue)
    }
  }
}
</script>

<style lang="less">
/*@import '../../styles/weui/widget/weui_cell/weui_cell_global';*/
/*
.vux-number-input {
  float:left;
  height:20px;
  font-size:20px;
  color: @number-input-font-color;
  appearance: none;
  border:1px solid #ececec;
  padding:3px 0;
  text-align:center;
  border-radius: 1px;
}
.vux-number-selector {
  float:left;
  height:20px;
  font-size:25px;
  line-height:18px;
  color:@number-button-font-color;
  border:1px solid #ececec;
}
.vux-number-selector.vux-number-disabled{
  color:#ccc;
}
.vux-number-selector-sub {
  border-right:none;
  padding:3px 10px;
  border-radius:2px 0 0 2px;
}
.vux-number-selector-plus {
  border-left:none;
  margin-right: 5px;
  padding:3px 8px;
  border-radius:0 2px 2px 0;
}*/
</style>
