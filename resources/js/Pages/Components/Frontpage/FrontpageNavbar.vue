<template>
    <v-list
        dense
    >
        <v-subheader>Tags</v-subheader>
        <v-list-item v-for="(tag, idx) in tags" v-bind:key="idx">
            <inertia-link :href="route('home', {tag_id: tag.id})" class="text-sm text-gray-700">
                <v-btn text>{{tag.name}}</v-btn>
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
