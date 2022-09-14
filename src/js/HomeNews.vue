<template>
  <div class="">
    <VueAgile :infinite="false">
      <div
        v-for="news in allNews"
        :key="news.id"
        class="slide relative overflow-hidden h-96 xl:h-[32rem]"
      >
        <div
          class="h-96 xl:h-[32rem] absolute bg-gray-400 w-screen overflow-hidden"
        >
          <a :href="news.link">
            <img
              :src="news.image"
              :alt="news.newsHeadline"
              class="w-full h-full object-top object-cover sm:w-full sm:h-full"
            />
          </a>
        </div>
        <div
          class="max-w-screen-2xl mx-auto h-96 xl:h-[32rem] pb-5 grid grid-cols-1 items-end"
        >
          <div class="p-5 z-0">
            <h3
              class="text-3xl mb-5 uppercase font-bold font-sans text-steelgreen"
            >
              <a
                class="bg-steelwhite decoration-clone py-1 px-3 leading-9"
                :href="news.link"
              >
                {{ news.newsHeadline }}</a
              >
            </h3>
            <a :href="news.link" class="btn-default">weiterlesen</a>
          </div>
        </div>
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
