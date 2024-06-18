<template>
  <RadiogroupElement rules="required" @change="onCategoryChange" :items="ticket_items" view="blocks">
    <template #label>
      <div class="text-lg leading-tight mt-2">Meine Kategorie:</div>
    </template>
  </RadiogroupElement>
</template>

<script>
import { inject, computed, watch } from 'vue'

export default {
  setup(props, context) {
    const form$ = inject('form$')

    const prices =
    {
      basic: {
        rollstuhl: 0.99,
        stehplatz: {
          vollzahler: 10.0,
          rentner: 8.0,
          student: 8.0,
          azubi: 8.0,
          schueler: 8.0,
          mitglied: 8.0,
          jugendlicher: 6.0,
          kind: 4.0,
          behinderung: 2.0,
          familie1: 15.0,
          familie2: 20.0,
          familie3: 25.0,
        },
        sitzplatz: {
          vollzahler: 20.0,
          rentner: 18.0,
          student: 18.0,
          azubi: 18.0,
          schueler: 18.0,
          mitglied: 18.0,
          jugendlicher: 16.0,
          kind: 14.0,
          behinderung: 12.0,
          familie1: 45.0,
          familie2: 50.0,
          familie3: 55.0,
        }
      },
      plus: {
        rollstuhl: 1.99,
        stehplatz: {
          vollzahler: 12.0,
          rentner: 10.0,
          student: 10.0,
          azubi: 10.0,
          schueler: 10.0,
          mitglied: 10.0,
          jugendlicher: 8.0,
          kind: 6.0,
          behinderung: 4.0,
          familie1: 18.0,
          familie2: 22.0,
          familie3: 28.0,
        },
        sitzplatz: {
          vollzahler: 22.0,
          rentner: 20.0,
          student: 20.0,
          azubi: 20.0,
          schueler: 20.0,
          mitglied: 20.0,
          jugendlicher: 18.0,
          kind: 16.0,
          behinderung: 14.0,
          familie1: 55.0,
          familie2: 60.0,
          familie3: 65.0,
        }
      }
    }

    const ticket_items = computed(() => {
      let items = [
        { value: 'vollzahler', label: 'Vollzahler', description: ticket_price['vollzahler'] },
        { value: 'rentner', label: 'Rentner', description: 'XXX,XX €' },
        { value: 'student', label: 'Student', description: 'XXX,XX €' },
        { value: 'azubi', label: 'Auszubildender', description: 'XXX,XX €' },
        { value: 'schueler', label: 'Schüler über 18 Jahre', description: 'XXX,XX €' },
        { value: 'mitglied', label: 'SC Mitglied', description: 'XXX,XX €' },
        { value: 'jugendlicher', label: 'Jugendlicher (13-17 Jahre)', description: 'XXX,XX €' },
        { value: 'kind', label: 'Kind (8-12 Jahre)', description: 'XXX,XX €' },
        { value: 'behinderung', label: 'Fan mit Behinderung ab 50%', description: 'XXX,XX €' },
      ]
      if (form$.value.data.ticket_area == 'sitzplatz') {
        items.push(
          { value: 'familie1', label: 'Familienkarte 1 (1 x Vollzahler + 2 Kinder/Jugendliche)', description: 'XXX,XX €' },
          { value: 'familie2', label: 'Familienkarte 2 (2 x Vollzahler + 1 Kind/Jugendlicher)', description: 'XXX,XX €' },
          { value: 'familie3', label: 'Familienkarte 3 (2 x Vollzahler + 2 Kinder/Jugendliche)', description: 'XXX,XX €' }
        )
      }

      if (form$.value.data.ticket_area == 'rollstuhl') {
        items = [
          { value: 'vollzahler', label: 'Vollzahler', description: ticket_price },
        ]
      }
      return items
    })

    const ticket_type = computed(() => {
      return form$.value.data.ticket_type
    })
    const ticket_area = computed(() => {
      return form$.value.data.ticket_area
    })
    const ticket_price = computed(() => {
      if (form$.value.data.ticket_type && form$.value.data.ticket_area) {
        return prices[form$.value.data.ticket_type][form$.value.data.ticket_area]
      }
      return {}
    })

    const onCategoryChange = (newValue, oldValue) => {
      if (newValue?.includes('familie') || oldValue?.includes('familie')) {
        form$.value.el$('ticket_seats.my_seat.seat_block').reset()
        form$.value.el$('ticket_seats.my_seat.seat_seat').reset()
        form$.value.el$('ticket_seats.my_seat.seat_row').reset()
      }
    }

// Familienkarte nur in C, I, K
    return {
      ticket_type,
      ticket_area,
      ticket_price,
      ticket_items,
      onCategoryChange,
    }
  },
}
</script>