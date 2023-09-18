<template>
    <div class="container">
        <table style="width: 80%">
            <caption colspan="2">List of Characters  / [ <router-link to="/dashboard" class="navbar-brand" href="#">Statistics Page</router-link> ]</caption>
            <thead>
                <tr>
                    <th style="width:20%; text-align:left"><b>Picture</b></th>
                    <th style="width:60%; text-align:left" scope="col"><b>Name</b></th>
                    <th style="width:20%; text-align:left" scope="col"><b>Status</b></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(character, index) in characters" :key="index">
                    <td style="text-align:center">
                        <router-link
                            :to="{
                                name: 'characterDetail',
                                params: {
                                    id: character.id
                                }
                            }">
                            <img v-bind:src="character.image" v-bind:alt="character.name" style="height:100px; width:100px" />
                        </router-link>
                    </td>
                    <td>{{ character.name }}</td>
                    <td style="text-align:center">{{ character.status }}</td>
                </tr>
            </tbody>
        </table>
        <br />
        <div class="pagination">
            <span><a href="#">&laquo;</a>
                <span v-for="iCnt in lastPage" :class="currentPage == iCnt ? 'active' : ''">
                    <router-link
                        :to="{
                            name: 'nextpage',
                            params: {
                                id: iCnt
                            }
                        }">
                        {{ iCnt }}
                    </router-link>
                </span>
                <a href="#">&raquo;</a>
            </span>
        </div>
    </div>
</template>

<script>
import {ref, onMounted} from 'vue'
import {request} from '../helper'
import Loader from '../components/Loader.vue';

export default {
    components: {
        Loader,
    },
    props: ['id'],
    setup(props) {
        const characters = ref([])
        const currentPage = ref(1)
        const lastPage = ref(0)
        const iCnt = ref(0)

        onMounted(() => {
            getCharacterList()
        });

        const getCharacterList = async () => {
            try {
                const req = await request('get', typeof props.id === "undefined" ? '/api/index' : '/api/page/' + props.id)
                characters.value = req.data.data
                lastPage.value = req.data.last_page
                currentPage.value = req.data.current_page
            } catch (e) {
                // 
            }
        }

        return {
            characters,            
            currentPage,
            lastPage,
            iCnt,
        }
    },
    
}
</script>

<style>
    table,
    th,
    td {
        border: 1px solid black;
    }

    .pagination {
        display: inline-block;
    }

    .pagination a {
        color: black;
        float: left;
        padding: 8px 16px;
        text-decoration: none;
        transition: background-color .3s;
        border: 1px solid #ddd;
    }

    .pagination a.active {
        background-color: #4CAF50;
        color: white;
        border: 1px solid #4CAF50;
    }

    .pagination a:hover:not(.active) {
        background-color: #ddd;
    }
</style>