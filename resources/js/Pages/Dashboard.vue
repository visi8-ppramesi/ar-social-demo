<template>
    <app-layout>
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                asdfasdfasdfasdf
            </h2>
        </template> -->

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <!-- <welcome /> -->
                    <front-page
                        :tags="tags"
                        :threads="threads"
                    />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import FrontPage from './FrontPage'

    export default {
        mounted: function(){
            console.log(this.props)
        },
        props:{
            canLogin: Boolean,
            canRegister: Boolean,
            threads: Array,
            tags: Array
        },
        components: {
            AppLayout,
            Welcome,
            FrontPage,
        },
    }
</script>
