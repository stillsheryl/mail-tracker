<template>
    <Transition>
        <!-- v-if="showModal" -->
        <!-- fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 p-4 -->
        <div v-show="showModal" class="
            modal-mask fixed w-full h-full top-0 left-0 z-[200]
            overflow-x-hidden overflow-y-auto
            "
        >
          <div class="modal-wrapper">
            <div class="modal-container">

              <div class="modal-header">
                <slot name="header">
                  Header
                </slot>
              </div>

              <div class="modal-body">
                <slot name="body">
                  Body
                </slot>
              </div>

              <div class="modal-footer">
                <slot name="footer">
                  Footer
                  <button class="modal-default-button" @click="$emit('close')">
                    OK
                  </button>
                </slot>
              </div>
            </div>
          </div>
        </div>
      </Transition>
</template>

<script setup lang="ts">

defineProps<{
    showModal: boolean;
}>();

</script>