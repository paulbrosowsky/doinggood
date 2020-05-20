<template>
    <div class="dg-editor">
        <editor-content 
            class="dg-editor" 
            :editor="editor" 
            :id="editorId"
        />
    </div>
    
</template>
<script>
    import { Editor, EditorContent } from 'tiptap';
    import {  Link, Placeholder } from 'tiptap-extensions';

    export default {
        components: {
            EditorContent,
        },

        props:{
            placeholder: {
                default: 'Erzähle mehr ...'
            },
            editorId:{
                default: 'editor'
            }
        },

        data() {
            return {                
                editor: new Editor({
                    // content: '<p>This is just a boring paragraph</p>',
                    
                    extensions: [
                        new Link(),
                        new Placeholder({
                            emptyEditorClass: 'is-editor-empty',
                            emptyNodeClass: 'is-empty',
                            emptyNodeText: this.placeholder,
                            showOnlyWhenEditable: true,
                            showOnlyCurrent: true,
                        }),                               
                    ],
                    onUpdate: ({getHTML}) => { 
                        var removeRegexP = /<p><\/p>/g;
                        let html = getHTML();
                        html = html.replace(removeRegexP, "<br>");

                        this.$emit('update', html);                         
                    },                    
                }),                
            }
        },        

        beforeDestroy() {
            // Always destroy your editor instance when it's no longer needed
            this.editor.destroy()
        },
    }
</script>

<style lang="scss">
    // Placeholder 
    .dg-editor p.is-editor-empty:first-child::before {
        content: attr(data-empty-text);
        float: left;
        color: #7486a4;
        pointer-events: none;
        height: 0;        
    }  
    
    .ProseMirror{  
        background: #e2e8f0;
        padding: 0.75rem;  
        min-height: 8em;
        border-radius: 0.5rem;

        &:focus{
            background: white;
            outline: none; 
            border: 2px solid #f7a81b;    
        }
    }  

</style>