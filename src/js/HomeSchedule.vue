<template>
  <div>
    <h4 class="uppercase font-bold text-3xl tracking-wide text-center">
      Spiele
    </h4>
    <div class="grid grid-cols-12 gap-1" satyle="grid-template-rows: 1fr 1fr">
      <div class="col-span-2 self-center">
        <button @click="currentIndex--" :disabled="currentIndex === 0">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            :class="[
              currentIndex === 0
                ? 'fill-slate-800 stroke-slate-800'
                : 'fill-white stroke-white',
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
      </div>
      <div class="col-span-2 place-self-center">
        <div
          :title="currentGame.home.name"
          class="h-40 w-40 bg-contain bg-no-repeat bg-center"
          :style="`background-image: url(https://www.penny-del.org/assets/img/teams/dark/team_${currentGame.home.shortname}.png)`"
        ></div>
      </div>
      <div
        class="col-span-4 place-self-center text-center font-bold font-headline"
      >
        <span class="text-8xl whitespace-nowrap tracking-tighter"
          >{{ currentGame.homescore }} : {{ currentGame.awayscore }}</span
        ><br />
        <span>{{ currentGame.resulttype }}</span>
      </div>
      <div class="col-span-2 place-self-center text-center">
        <div
          :title="currentGame.away.name"
          class="h-40 w-40 bg-contain bg-no-repeat bg-center"
          :style="`background-image: url(https://www.penny-del.org/assets/img/teams/dark/team_${currentGame.away.shortname}.png)`"
        ></div>
      </div>
      <div class="col-span-2 place-self-center justify-self-end">
        <button
          @click="currentIndex++"
          :disabled="currentIndex + 1 === allGames.length"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            x="0px"
            y="0px"
            class="rotate-180"
            :class="[
              currentIndex + 1 === allGames.length
                ? 'fill-slate-800 stroke-slate-800'
                : 'fill-white stroke-white',
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
        class="col-span-2 col-start-3 place-self-center text-center mt-3 whitespace-nowrap"
      >
        {{ currentGame.home.name }}
      </div>
      <div
        class="col-span-2 col-start-9 place-self-center text-center mt-3 whitespace-nowrap"
      >
        {{ currentGame.away.name }}
      </div>
    </div>
    <hr class="border-t border-gray-400 my-5" />
    <div>
      <h4 class="font-bold text-2xl tracking-tight text-center">
        Penny DEL - Hauptrunde - Spiel {{ currentIndex + 1 }}
      </h4>
      <p class="text-center text-sm mt-3">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-5 w-5 inline-block mb-0.5 mr-1"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          stroke-width="2"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
          />
        </svg>
        <span>{{ currentGame.displayDate }}</span>
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-5 w-5 inline-block mb-0.5 mr-1 ml-4"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          stroke-width="2"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
          />
        </svg>
        <span>{{ currentGame.displayTime }} Uhr</span>
      </p>
    </div>
    <hr class="border-t border-gray-400 my-5" />
    <div class="text-center">
      <a href="/tickets" class="btn-default">Tickets</a>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";

const allGames = window.tilastot_gamedata;

const currentIndex = ref(0);

const currentGame = computed(() => {
  const game = allGames[currentIndex.value];
  const date = new Date(game.gamedate * 1000);
  game.displayDate = new Intl.DateTimeFormat("de-DE", {
    weekday: "long",
    year: "numeric",
    day: "numeric",
    month: "long",
  }).format(date);
  game.displayTime = new Intl.DateTimeFormat("de-DE", {
    hour: "numeric",
    minute: "2-digit",
  }).format(date);
  return game;
});
</script>
