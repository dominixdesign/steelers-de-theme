<template>
  <div class="flex place-content-between flex-col h-full">
    <h4 class="uppercase font-bold text-3xl tracking-wide text-center">
      Tabelle
    </h4>
    <div>
      <table class="w-full border-separate border-spacing-0.5">
        <thead class="uppercase font-bold">
          <tr>
            <th class="text-right">Platz</th>
            <th class="text-left">Team</th>
            <th class="text-right pr-2">Spiele</th>
            <th class="text-center">Tore</th>
            <th class="text-right pr-2">P/Sp.</th>
          </tr>
        </thead>
        <tbody>
          <template v-for="row of standings" :key="`standings-row-${row.id}`">
            <tr>
              <td colspan="5"><hr class="border-t border-gray-400" /></td>
            </tr>
            <tr
              :class="[
                row.tilastotid === '22' ? 'text-steellightgreen font-bold' : '',
              ]"
            >
              <td class="text-right py-2 pr-2">{{ row.id }}.</td>
              <td class="text-left flex items-center py-2">
                <span
                  :title="row.name"
                  class="h-8 w-8 block bg-contain bg-no-repeat bg-center"
                  :style="row.logo ? `background-image: url(${row.logo}` : ''"
                ></span>
                <span class="block ml-4 uppercase">{{ row.name }}</span>
              </td>
              <td class="text-right py-2 pr-2">{{ row.games }}</td>
              <td class="text-center py-2">
                {{ row.goalsfor }}:{{ row.goalsagainst }}
              </td>
              <td class="text-right py-2 pr-2">
                {{
                  new Intl.NumberFormat("de-DE", {
                    maximumSignificantDigits: 3,
                  }).format(row.points / row.games)
                }}
              </td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>
    <div class="text-center border-t border-gray-400 my-5 pt-5">
      <a href="/saison/tabelle" class="btn-default">Vollständige Tabelle</a>
    </div>
  </div>
</template>

<script setup>
const standings = window.tilastot_standings;
</script>
