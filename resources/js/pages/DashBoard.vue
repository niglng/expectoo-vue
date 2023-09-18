<template>
    <main>
        <router-link to="/" class="navbar-brand" href="#">Go to Home</router-link>

        <table style="width: 80%">
            <caption colspan="2">The top 3 characters that appeared in the most episodes</caption>
            <tbody>
                <tr>
                    <td v-for="character in top3Characters" :key="character.id">
                        <img :src="character.image" style="height:100px; width:100px" v-bind:alt=" character.name">
                        <div><span><b>Name: </b>{{ character.name }}</span></div>
                        <div><span><b>Episode(s) in: </b>{{ character.episode }}</span></div>
                    </td>
                    
                    <td v-if="top3Characters.length === 0">
                        <div>None for now</div>
                    </td>
                </tr>
            </tbody>
        </table>
        <br />

        <table style="width: 80%">
            <caption colspan="2">The Status that is assigned to the most characters <h4>{{ statusMost }}</h4>
            </caption>
        </table>
        <br />

        <table style="width: 80%">
            <caption colspan="2">The Location with the most characters of the species “human”</caption>
            <tbody>
                <tr>
                    <td style="text-align:center">
                        <div><span>
                                <h4>{{ location.name }}</h4> appeared <b>{{ location.counts }}</b>
                            </span></div>
                    </td>
                </tr>
            </tbody>
        </table>
        <br />

        <table style="width: 80%">
            <caption colspan="2">The species with the most male characters</caption>
            <tbody>
                <tr>
                    <td style="text-align:center">
                        <div><span>
                                <h4>{{ mostMale.name }}</h4> appeared <b>{{ mostMale.counts }}</b>
                            </span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <br />


        <table style="width: 80%">
            <caption colspan="2">A List with all unique origin names [total number of unique origin = {{
                originDisplay.length }}]</caption>
            <tbody>
                <thead>
                    <tr>
                        <th style="width:30%; text-align:left"><b>Origin Name</b></th>
                        <th style="width:50%; text-align:left" scope="col"><b>Species</b></th>
                    </tr>
                </thead>
                <tr v-for="origin in originDisplay" :key="origin.id">
                    <td style="width:30%; text-align:center"><span>{{ origin.name }} [{{ origin.speciesCount }}]</span></td>
                    <td style="width:50%; text-align:left">
                        <p v-for="value in origin.species" :key="value.id">
                            <span>{{ value.name }} [{{ value.count }} ] </span>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
        <br />
    </main>
</template>


<script>
import {ref, onMounted} from 'vue'
import {request} from '../helper'
import Loader from '../components/Loader.vue';

export default {
  components: {
      Loader,
  },
  setup() {
    const top3Characters = ref([])
    const statusMost = ref('')
    const location = ref([])
    const mostMale = ref([])
    const originDisplay = ref([])

    onMounted(() => {
      getStatistics()
    })

    const getStatistics = async () => {
      try {
        const req = await request('get', '/api/dashboard')
        top3Characters.value = req.data.bestThree
        statusMost.value = req.data.statusMost
        location.value = req.data.location
        mostMale.value = req.data.mostMale
        originDisplay.value = req.data.originDisplay
      } catch (e) {
        //
      }
    }

    return {
        top3Characters,
        statusMost,
        location,
        mostMale,
        originDisplay,
    }
  },
}
</script>