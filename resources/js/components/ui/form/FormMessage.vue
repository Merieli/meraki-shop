<script lang="ts" setup>
import { ErrorMessage } from 'vee-validate';

defineProps<{
  name: string;
}>()

</script>

<template>
  <ErrorMessage
    as="p"
    :name
    class="text-sm font-medium text-destructive"
  />
</template>
