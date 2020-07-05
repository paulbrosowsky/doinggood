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
                value: this.selected,
                options: [
                    { label: '2 km', value: 2 },
                    { label: '5 km', value: 5 },
                    { label: '10 km', value: 10 },
                    { label: '20 km', value: 20 },
                    { label: '50 km', value: 50 }, 
                    { label: '100 km', value: 100 },
                    { label: '150 km', value: 150 },
                    { label: '200 km', value: 200 },
                    { label: '500 km', value: 500 }
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
                this.value = { label: `${this.selected} km`, value: this.selected};
            }
        }
        
    }
</script>