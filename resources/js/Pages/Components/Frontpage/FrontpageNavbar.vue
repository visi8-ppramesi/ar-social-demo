<template>
    <v-list
        dense
    >
        <v-subheader>Tags</v-subheader>
        <v-list-item v-for="(tag, idx) in tags" v-bind:key="idx">
            <inertia-link :href="route('dashboard', {tag_id: tag.id})" class="ml-4 text-sm text-gray-700 underline">
                {{tag.name}}
            </inertia-link>
        </v-list-item>
    </v-list>
</template>

<script>
export default {
    name: "frontpage-navbar",
    props: ["tags"],
}
</script>
