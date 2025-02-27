<script setup lang="ts">
import Button from 'primevue/button'

const isVisible = ref(false)

function checkScroll(): void {
  isVisible.value = window.scrollY > 300
}

function scrollToTop(): void {
  window.scrollTo({ top: 0, behavior: 'smooth' })
}

onMounted(() => window.addEventListener('scroll', checkScroll))
onUnmounted(() => window.removeEventListener('scroll', checkScroll))
</script>

<template>
  <Transition name="fade">
    <Button
      v-show="isVisible"
      class="scroll-to-top"
      aria-label="Scroll to top"
      @click="scrollToTop"
    >
      <img src="../../images/shared/icon-arrow-up.svg" alt="Arrow up" />
    </Button>
  </Transition>
</template>

<style lang="scss">
.scroll-to-top {
  position: fixed;
  bottom: 2rem;
  right: 2rem;
  width: 3rem;
  height: 3rem;
  cursor: pointer;
  align-items: center;
  justify-content: center;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transition: background-color 0.2s;
  z-index: 2;

  img {
    width: 0.8rem;
    filter: brightness(0) invert(1);
  }

  &:hover {
    background: var(--color-hover-purple);
  }
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
