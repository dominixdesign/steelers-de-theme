<template>
  <GroupElement :name="'my_seat' + suffix">
    <SelectElement :name="'block' + suffix" rules="required" placeholder="Block" :native="false" :items="[
        'Black A',
        'Block B',
        'Block C',
        'Block F',
        'Block G',
        'Block H',
        'Block I',
        'Block J',
        'Block K',
        'Block L',
      ]" :columns="{
        container: 4,
        label: 12,
        wrapper: 12,
      }" />
    <SelectElement :name="'seat' + suffix" rules="required" placeholder="Reihe" :native="false"
      :items="Array.from({ length: 21 }, (_, i) => 'Reihe '.concat(i + 1) )" :columns="{
        container: 4,
        label: 12,
        wrapper: 12,
      }" />
    <SelectElement :name="'row' + suffix" rules="required" placeholder="Platz" :native="false"
      :items="Array.from({ length: 24 }, (_, i) => 'Platz '.concat(i + 1))" :columns="{
        container: 4,
        label: 12,
        wrapper: 12,
      }" />
  </GroupElement>
</template>

<script>
import { inject, computed } from 'vue'

export default {
  props: {
    suffix: String
  },
  setup(props, context) {
    const form$ = inject('form$')
    console.log(props.suffix)
  },
}
</script>