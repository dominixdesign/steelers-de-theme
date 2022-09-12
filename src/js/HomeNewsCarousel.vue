<template>
  <div class="relative">
    <div class="h-4/6 absolute bg-black w-screen overflow-hidden z-0">
      <img
        :src="allNews[0].image"
        class="w-full h-full object-top object-cover opacity-20"
      />
    </div>
    <h3 class="text-steelgreen z-10">Steelers News</h3>
    <VueAgile :infinite="true" :slidesToShow="3">
      <div
        class="bg-white shadow m-5"
        style="width: 320px; max-width: 320px"
        v-for="news in allNews"
        :key="news.id"
      >
        <a class="col-span-1 flex flex-col" :href="news.link">
          <div class="bg-white overflow-hidden relative" style="height: 400px">
            <img
              :src="news.image"
              witdh="320"
              height="400"
              class="object-center object-cover"
            />
          </div>
          <div>
            <div class="p-5 uppercase">
              <div class="font-bold">Katgeorie</div>
              <div
                class="-mt-2 text-xl text-steelgreen font-bold leading-tight"
              >
                {{ news.newsHeadline }}
              </div>
            </div>
          </div>
        </a>
      </div>
      <template v-slot:prevButton
        ><svg
          xmlns="http://www.w3.org/2000/svg"
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
          </g></svg
      ></template>
      <template v-slot:nextButton>
        <svg
          xmlns="http://www.w3.org/2000/svg"
          x="0px"
          y="0px"
          class="rotate-180"
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
          </g></svg
      ></template>
    </VueAgile>
  </div>
</template>

<script setup>
import { VueAgile } from "vue-agile";

const allNews = window.steelers_home_news;
</script>
