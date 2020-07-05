<template>        
    <div/>
</template>
<script>   
    import places from 'places.js';

    export default {

        props:['value'],

        data() {
            return { 
                instance: null
            }
        },
        mounted() {
            this.input = document.createElement('input');
            this.input.placeholder = "Standort ...";
            this.value ? this.input.value = this.value : '';

            this.$el.appendChild(this.input);

            this.instance = places({
                container: this.input,
            });

            this.instance.on('change', e => {
                this.$emit('change', e);
            });
        },
        beforeDestroy() {           
            this.instance.destroy();
            this.instance.off('change');
        },
    }   
</script>
<style lang="scss">
    .algolia-places{
        .ap-input{
            height: 3em;
            background-color: #e2e8f0;
            border-radius: 0.5rem;
            border: 2px solid #e2e8f0;

            &:focus{
                background-color: white;
                border-color: #f7a81b;
            }            
        }

        .ap-dropdown-menu{
            border-radius: 0.5rem;

            .ap-footer{
                display: flex;
                align-items: center;
                justify-content: flex-end;

                a{
                    display: flex;
                    margin: 0.5rem;
                }
            }
        }
    }
   
</style>