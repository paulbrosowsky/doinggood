<script>
    import AccountForm from './AccountForm';
    import ProfileForm from "./ProfileForm";

    export default {
        components:{ AccountForm, ProfileForm },

        props:['user', 'categories', 'tags'],

        data(){
            return{
                preview: null
            }
        },

        computed:{
            avatar(){
                return this.preview ? this.preview : this.user.avatar;
            }
        },

        methods:{
            showPreview(image){
                this.preview = image;
            },

            removePreview(){
                this.preview = null;
            }
        }
    }
</script>