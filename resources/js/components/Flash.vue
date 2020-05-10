<template>
    <div :class="classes"         
         role="alert"
         v-show="show"
         v-text="body">
    </div>
</template>

<script>
    export default {
        props: ['message'],

        data() {
            return {
                body: this.message,
                level: 'success',
                show: false
            }
        },

        computed: {
            classes() {
                let defaults = 'fixed text-white rounded-lg p-4 bottom-0 right-0 z-50 w-full text-sm break-words md:w-auto md:max-w-md md:mx-5 md:my-5 ';
                
                if (this.level === 'success') defaults = defaults.concat('bg-dg-blue');
                if (this.level === 'warning') defaults = defaults.concat('bg-dg-yellow');
                if (this.level === 'danger')  defaults =  defaults.concat('bg-dg-red');
           
                return defaults;
            }
        },

        created() {
            if (this.message) {
                this.flash();
            }

            window.Event.$on(
                'flash', data => this.flash(data)
            );
        },

        methods: {
            flash(data) {
                if (data) {
                    this.body = data.message;
                    this.level = data.level;
                }

                this.show = true;

                this.hide();
            },

            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 3000);
            }
        }
    };
</script>
