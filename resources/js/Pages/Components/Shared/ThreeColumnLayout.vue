<template>
    <v-container fluid>
        <v-row>
            <v-col cols="2" v-if="$vuetify.breakpoint.mdAndUp">
                <slot name="column-one"></slot>
            </v-col>
            <v-col cols="12" md="8" xs="12">
                <slot name="column-two"></slot>
            </v-col>
            <v-col cols="2" v-if="$vuetify.breakpoint.mdAndUp">
                <slot name="column-three"></slot>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: 'three-column-layout'
}
</script>
