<template>
  <div class="<?= $this->class ?> mt-64 pointer-events-none">
    <div class="max-w-screen-2xl mx-auto relative py-4 my-32 z-40 flex">
      <h2 class="block-headline headline--small">Shop</h2>
    </div>
  </div>
  <div
    class="<?= $this->class ?> max-w-screen-2xl mx-auto relative my-20 -mt-64"
  >
    <div class="grid grid-cols-11">
      <div class="pt-10 col-span-2 relative">
        <a
          :href="currentProduct.link"
          class="btn-default absolute -right-32 top-56"
          >Jetzt kaufen</a
        >
        <h3 class="text-4xl text-black">Edition 2022/23</h3>
      </div>
      <div
        class="aspect-1 col-span-3"
        v-for="product in shopData.slice(currentIndex, currentIndex + 3)"
        :key="product.name"
      >
        <a :href="product.link" class="h-[480px] w-[480px]">
          <img
            class="aspect-1 object-cover"
            :alt="product.name"
            :title="product.name"
            :src="product.image"
          />
        </a>
      </div>
    </div>
    <div class="py-4 pt-7 flex justify-between">
      <div class="flex gap-14">
        <button
          @click="currentIndex--"
          :disabled="currentIndex === 0"
          aria-label="vorheriges Produkt"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            :class="[
              currentIndex === 0
                ? 'fill-slate-300 stroke-slate-300'
                : 'fill-black stroke-black',
            ]"
            x="0px"
            y="0px"
            width="60px"
            height="40px"
            viewBox="0 0 60 40"
          >
            <g>
              <line
                stroke-width="2"
                x1="62.5"
                y1="20.031"
                x2="20.5"
                y2="20.031"
              />
              <polygon
                stroke-miterlimit="10"
                points="21,25 15.406,20.093 21,15.06"
              />
              <path
                d="M19.938,2.045c9.866,0,17.893,8.026,17.893,17.893S29.804,37.83,19.938,37.83S2.045,29.804,2.045,19.938
S10.071,2.045,19.938,2.045 M19.938,0C8.926,0,0,8.926,0,19.938c0,11.011,8.926,19.938,19.938,19.938s19.938-8.927,19.938-19.938
C39.875,8.926,30.949,0,19.938,0L19.938,0z"
              />
            </g>
          </svg>
        </button>
        <button
          @click="currentIndex++"
          :disabled="currentIndex + 3 === shopData.length"
          aria-label="nächstes Produkt"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            x="0px"
            y="0px"
            class="rotate-180"
            :class="[
              currentIndex + 3 === shopData.length
                ? 'fill-slate-300 stroke-slate-300'
                : 'fill-black stroke-black',
            ]"
            width="60px"
            height="40px"
            viewBox="0 0 60 40"
          >
            <g>
              <line
                fill="none"
                stroke-width="2"
                x1="62.5"
                y1="20.031"
                x2="20.5"
                y2="20.031"
              />
              <polygon
                stroke-miterlimit="10"
                points="21,25 15.406,20.093 21,15.06"
              />
              <path
                d="M19.938,2.045c9.866,0,17.893,8.026,17.893,17.893S29.804,37.83,19.938,37.83S2.045,29.804,2.045,19.938
		S10.071,2.045,19.938,2.045 M19.938,0C8.926,0,0,8.926,0,19.938c0,11.011,8.926,19.938,19.938,19.938s19.938-8.927,19.938-19.938
		C39.875,8.926,30.949,0,19.938,0L19.938,0z"
              />
            </g>
          </svg>
        </button>
      </div>
      <div
        class="w-1/3 text-right border-t-2 border-black pt-3 uppercase font-bold"
      >
        <a href="https://shop.steelers.de" class="link-default">zum Shop</a>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";

const shopData = window.steelers_shopdata;

const currentIndex = ref(0);
const currentProduct = computed(() => {
  return shopData[currentIndex.value];
});
</script>
