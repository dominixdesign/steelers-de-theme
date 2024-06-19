<template>
  <div class="bg-black/5 col-span-12 p-8 mt-4 rounded-lg">
    <!-- Dauerkarte details -->
    <div class="col-span-12 flex justify-between">
      <div class="flex items-start mr-6">
        <span class="flex-grow-0 font-bold whitespace-nowrap flex-shrink-0 text-steelgreen">Meine Dauerkarte
          2024/2025</span>
      </div>
      <div class="text-sm text-steelblue"><a href="" @click.prevent="handleChangeDauerkarte">Ändern</a></div>
    </div>
    <div class="col-span-12">
      Stehplatz - EgeTrans Block - Rentner - xx,xx€<br>
      Bezahlung per Überweisung
    </div>
    <!-- Kontakt details -->
    <div class="col-span-12 flex justify-between pt-5 mt-5 border-t border-gray-200 ">
      <div class="flex items-start mr-6">
        <span class="flex-grow-0 font-bold whitespace-nowrap flex-shrink-0 text-steelgreen">Meine
          Kontaktdaten</span>
      </div>
      <div class="text-sm text-steelblue"><a href="" @click.prevent="handleChangeContact">Ändern</a></div>
    </div>
    <div class="col-span-12 pb-2">
      Dominik Sander<br>
      Gröninger Weg 8<br>
      74321 Bietigheim-Bissingen<br>
      014258<br>
      mail<br>
    </div>
  </div>
  <CheckboxElement name="data_privacy" rules="required">
    Ich akzeptiere die Allgemeinen Datenschutzbestimmungen der Steelers GmbH sowie die Konditionen und
    Bedingungen zur Dauerkarte 2024/2025. Die AGB sind jederzeit im Internet unter: http://www.steelers.de/agb
    nachzulesen. Des Weiteren habe ich die Datenschutzrichtlinie zur Kenntnis genommen. Diese ist auf der
    Geschäftsstelle sowie auf der Homepage der Steelers GmbH einsehbar. Die Steelers GmbH ist berechtigt, meine
    persönlichen Daten zu nutzen, um eine entsprechende Dauerkarte beim Ticketdienstleister erstellen zu können.
  </CheckboxElement>
  <CheckboxElement name="terms" rules="required">
    Ich habe die AGBs zur Kenntnis genommen und stimme diesen zu.
  </CheckboxElement>



</template>

<script>
import { inject, computed } from 'vue'

export default {
  setup(props, context) {
    const form$ = inject('form$')

    const ticket_type = computed(() => {
      return form$.value.data.ticket_type
    })
    const ticket_area = computed(() => {
      return form$.value.data.ticket_area
    })

    // `Shipping address` data
    const shipTo = computed(() => {
      const data = form$.value.data
      const parts = ['address', ',', 'address2', ',', 'city', 'state', 'zip_code', ',', 'country']

      return parts.map((part, i) => {
        if (part === ',') {
          return data[parts[i - 1]] ? part : ''
        }

        let value = data[part]

        return value && i > 0 ? ' ' + value : value
      }).join('')
    })



    const handleChangeDauerkarte = () => {
      form$.value.steps$.goTo('my_season_ticket')
    }

    const handleChangeContact = () => {
      form$.value.steps$.goTo('my_information')
    }

    return {
      ticket_type,
      shipTo,
      handleChangeDauerkarte,
      handleChangeContact,
    }
  },
}
</script>