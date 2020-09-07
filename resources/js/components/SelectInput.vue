<template>
    <div>
        <multiselect 
            v-model="value" 
            :options="options" 
            :searchable="false"             
            :show-labels="false" 
            placeholder="Wirkradius"
            track-by="value"
            label="label"
            @select="changed"
        >
            <template slot="singleLabel" slot-scope="{ option }">{{ option.label }}</template>
        </multiselect>
    </div>
</template>
<script>
    import Multiselect from 'vue-multiselect';
    export default {
        components: {
            Multiselect
        },

        props:['selected'],

        data () {
            return {
                value: null,
                options: [
                    { label: '20 km', value: 20 },
                    { label: '100 km', value: 100 },
                    { label: '200 km', value: 200 },
                    { label: '500 km', value: 500 },
                    { label: 'bundesweit', value: 1000 },
                ] 
            }
        },

        methods:{
            changed(event){
                this.$emit('change', event.value);
            }
        },

        mounted(){
            if (this.selected) {
                this.value = this.options.find((item)=>{
                    return item.value === this.selected;
                });
            }
        }
        
    }
</script>