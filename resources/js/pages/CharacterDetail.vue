<template>
  <main>
    <p><a @click="$router.go(-1)" class="btn btn-primary navbar-brand">Return to List</a></p>

    <table style="width: 80%">
        <caption colspan="2">Character Detail</caption>
        <tbody>
            <tr>
                <td style="width:30%; text-align:center"><img :src="character.image" v-bind:alt="character.name" style="height:400px; width:400px"></td>
                <td style="width:50%; text-align:left">
                  <span><b>Name:</b> {{ character.name }} </span><br />
                  <span><b>Specie:</b> {{ character.species }} </span><br />
                  <span><b>Date Created:</b> {{ dateFormat(character.created) }} </span><br />
                  <span><b>Status:</b> {{ character.status }} </span><br />
                  <span><b>Gender:</b> {{ character.gender }}</span><br />
                  <span><b>Location:</b> {{ characterLocation }} </span><br />
                  <span><b>Episode featured:</b> {{ characterFeatures.length }} </span><br />
                </td>
            </tr>
        </tbody>
    </table>
  </main>

</template>
  
<script>
import {ref, onMounted} from 'vue'
import {request} from '../helper'
import Loader from '../components/Loader.vue';

export default {
  props: ['id'],
  components: {
      Loader,
  },
  setup(props) {
    const character = ref([])
    const characterLocation = ref('')
    const characterFeatures = ref([])

    onMounted(() => {
      getCharacterById()
    })

    const getCharacterById = async () => {
      try {
        const req = await request('get', '/api/character/detail/' + props.id)
        character.value = req.data
        characterLocation.value = req.data.location.name
        characterFeatures.value = req.data.episode
      } catch (e) {
        // 
      }
    }

    return {
      character,
      characterLocation,
      characterFeatures,
    }
  },

  methods: {
    dateFormat(dateString) {
      var date = new Date(dateString);
      var result = (date.getDate() > 9 ? '' : '0') + date.getDate() + "-" + ((date.getMonth() + 1) > 9 ? '' : '0') + (date.getMonth() + 1) + "-" + date.getFullYear()
      return result
    },
  },
}
</script>