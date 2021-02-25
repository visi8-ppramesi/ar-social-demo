import { defaultFormat } from 'moment'
import Vue from 'vue'
const state = Vue.observable({counter: 0})
export const increment = () => state.counter++
export const decrement = () => state.counter--
export default state
