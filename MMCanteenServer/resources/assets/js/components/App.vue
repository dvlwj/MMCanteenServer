<template>
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">
            <router-link to="/">Dashboard</router-link>
            <router-link to="/petugas">Petugas</router-link>
            <router-link to="/siswa">Siswa</router-link>
          </div>

          <router-view></router-view>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "App",
  mounted() {
    console.log("App mounted.");
  }
};
</script>
