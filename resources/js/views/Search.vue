<script>
    import algoliasearch from 'algoliasearch/lite';

    export default {
        props:['algoliaId', 'algoliaSecret'],

        data(){
            return{
                searchClient: algoliasearch(
                    this.algoliaId,
                    this.algoliaSecret
                )                  
            }
        },

        methods:{
            toggleSidebar(){
                Event.$emit('toggle-sidebar');
            }
        }
    }
</script>  