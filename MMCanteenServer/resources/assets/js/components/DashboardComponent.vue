<template>
  <div class="container">
      <div class="row">
          <div class="col-md-8 col-md-offset-2">
              <div class="panel panel-default">
                  <div class="panel-heading">Dashboard</div>

                  <div class="panel-body">
                      I'm an example DashboardComponent!
                  </div>
              </div>
          </div>
      </div>
  </div>
</template>

<script>
export default {
  name: "Dashboard",
  mounted() {
    console.log("DashboardComponent mounted.");
  }
};
</script>
