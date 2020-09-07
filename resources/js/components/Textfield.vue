<template>
    <div>
        <textarea 
            class="w-full resize-none bg-gray-300 rounded-lg border-2 p-3 focus:bg-white  focus:border-dg-yellow focus:outline-none" 
            ref="textfield" 
            :maxlength="maxLength" 
            :placeholder="placeholder"          
            v-model="value"
            @input="autoResize"
        ></textarea>

        <p 
            class="text-right text-sm text-gray-500" 
            :class="maxLenghtAcheived" 
            v-if="maxLength"
        >
            {{`${currentValue} / ${maxLength}`}}
        </p>
    </div>
</template>
<script>
    export default {
        props:{
            text:{ type: String },
            placeholder:{ default: 'Ezähle etwas ...'},
            maxLength:{ default: null}
        },

        data(){
            return{
                value: this.text
            }
        },

        computed:{
            currentValue(){
                return this.value ? this.value.length : 0;
            },

            maxLenghtAcheived(){
                if (this.value) {
                   return  this.value.length == this.maxLength ? 'text-red-500' : '';
                }
            }
        },

        methods:{
            autoResize(event){
                event.target.style.height = 'auto';
                event.target.style.height = `${event.target.scrollHeight + 5}px`; 
                
                this.$emit('input', this.value);
            }
        },

        mounted(){
            this.$nextTick(()=>{                
                this.$refs.textfield.setAttribute("style", `height:${this.$refs.textfield.scrollHeight + 5}px`);
            });
           
        }
        
    }
</script>