<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component, {{ greeting }}.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import { defineComponent, ref } from 'vue'

    export default defineComponent({
        name: 'ExampleComponent',
        setup() {
            const greeting = ref('hello')

            return {
                greeting
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    })
</script>
