<template>
  <div class="card">
    <div class="card-header">
      <h2>Tambah Data Uji</h2>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th colspan="2">Info Ban</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th>Merek</th>
              <td>{{tire.merek}}</td>
            </tr>
            <tr>
              <th>Nomor Ban</th>
              <td>{{tire.nomor_ban}}</td>
            </tr>
            <tr>
              <th>Posisi</th>
              <td>{{tire.posistion}}</td>
            </tr>
            <tr>
              <th>Stempel Ban</th>
              <td>{{tire.stempel_ban}}</td>
            </tr>
            <tr>
              <th>Dibuat Oleh</th>
              <td>{{tire.user.name}}</td>
            </tr>
            <tr>
              <th>Kendaraan Saat ini</th>
              <td>
                {{tire.vehicle.merek}}
                <br />
                {{tire.vehicle.platnumber}}
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <fieldset>
        <legend class="w-auto">Form Service</legend>
        <div class="alert alert-danger" v-if="Object.keys(error).length>0" role="alert">
          <p class="mb-0">
            <span v-for="(e,i) in error" :key="i" class="clearfix">{{e[0]}}</span>
          </p>
        </div>
        <form @submit.prevent="submitData">
          <div class="form-group row">
            <div class="col-md-4">
              <label for="tekananangin">Tekanan Angin</label>
              <input
                type="number"
                class="form-control"
                id="tekananangin"
                v-model="service.tekanan_angin"
              />
            </div>

            <div class="col-md-4">
              <label for="posisi">Posisi</label>
              <input
                type="number"
                id="posisi"
                v-model="service.posisi"
                class="form-control"
                min="1"
                max="11"
              />
            </div>
            <div class="col-md-4">
              <label for="jarak">Jarak Km</label>
              <input type="number" id="jarak" v-model="service.jarakkm" class="form-control" />
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <label for>Tebal Tapak</label>
            </div>
            <div class="col-md-6" v-for="(n,i) in 6" v-bind:key="n">
              <div class="form-group">
                <input
                  type="number"
                  :name="`tebal_tapak[${i}]`"
                  v-model="service.tebal_tapak[i]"
                  :placeholder="`Tebal Tapak ${n}`"
                  class="form-control"
                  step="0.01"
                  min="0"
                />
              </div>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-md-4">
              <label for>Keterangan lain</label>
              <div class="form-check">
                <input
                  type="checkbox"
                  id="misalignment"
                  class="form-check-input"
                  v-model="service.kelainan"
                  value="Misalignment"
                />
                <label for="misalignment">Misalignment</label>
              </div>
              <div class="form-check">
                <input
                  type="checkbox"
                  v-model="service.kelainan"
                  id="tutuppentil"
                  class="form-check-input"
                  value="Tutup pentil tidak ada"
                />
                <label for="tutuppentil">Tutup pentil tidak ada</label>
              </div>
              <div class="form-check">
                <input
                  type="checkbox"
                  v-model="service.kelainan"
                  id="minplustekananangin"
                  class="form-check-input"
                  value="Kekurangan / Kelebihan Tekanan Angin"
                />
                <label for="minplustekananangin">Kekurangan / Kelebihan Tekanan Angin</label>
              </div>
              <div class="form-check">
                <input
                  type="checkbox"
                  v-model="service.kelainan"
                  id="pentilrusak"
                  class="form-check-input"
                  value="Pentil rusak"
                />
                <label for="pentilrusak">Pentil rusak</label>
              </div>
              <div class="form-check">
                <input
                  type="checkbox"
                  v-model="service.kelainan"
                  id="bautroda"
                  class="form-check-input"
                  value="Baut roda longgar / rusak"
                />
                <label for="bautroda">Baut roda longgar / rusak</label>
              </div>
              <div class="form-check">
                <input
                  type="checkbox"
                  v-model="service.kelainan"
                  id="sobek"
                  class="form-check-input"
                  value="Ban cacat / sobek"
                />
                <label for="sobek">Ban cacat / sobek</label>
              </div>
            </div>
            <div class="col-md-8">
              <label for="catatan">Catatan</label>
              <textarea
                name="catatan"
                id="catatan"
                rows="7"
                class="form-control"
                v-model="service.catatan"
              ></textarea>
            </div>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Upload Foto</label>
            <div class="custom-file">
              <input type="file" id="file" ref="file" @change="previewImage()" accept="image/*" />
              <label class="custom-file-label" for="file">Choose file</label>
            </div>
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary">simpan</button>
            <button
              class="btn btn-danger"
              type="button"
              data-toggle="modal"
              data-target="#lepasBan"
            >Lepas ban?</button>
          </div>
        </form>
      </fieldset>
    </div>

    <!-- Modal -->
    <div
      class="modal fade"
      id="lepasBan"
      tabindex="-1"
      role="dialog"
      aria-labelledby="lepasBanLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form @submit.prevent="lepasbanHandler">
            <div class="modal-header">
              <h5 class="modal-title" id="lepasBanLabel">Alasan Lepas Ban</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <!-- <form @submit.prevent="lepasbanHandler"> -->
              <div class="alert alert-danger" v-if="Object.keys(error).length>0" role="alert">
                <p class="mb-0">
                  <span v-for="(e,i) in error" :key="i" class="clearfix">{{e[0]}}</span>
                </p>
              </div>
              <div class="form-check">
                <input
                  type="checkbox"
                  v-model="service.alasanlepas"
                  id="gundul"
                  value="Gundul"
                  class="form-check-input"
                />
                <label for="gundul" class="form-check-label">Gundul</label>
              </div>
              <div class="form-check">
                <input
                  type="checkbox"
                  v-model="service.alasanlepas"
                  id="aus"
                  value="Aus / Tidak rata"
                  class="form-check-input"
                />
                <label for="aus" class="form-check-label">Aus / Tidak rata</label>
              </div>
              <div class="form-check">
                <input
                  type="checkbox"
                  v-model="service.alasanlepas"
                  id="rusak"
                  value="Rusak / Bocor"
                  class="form-check-input"
                />
                <label for="rusak" class="form-check-label">Rusak / Bocor</label>
              </div>
              <div class="form-check">
                <input
                  type="checkbox"
                  v-model="service.alasanlepas"
                  id="buang"
                  value="Vulkanisir / Buang"
                  class="form-check-input"
                />
                <label for="buang" class="form-check-label">Vulkanisir / Buang</label>
              </div>
              <div class="form-check">
                <input
                  type="checkbox"
                  v-model="service.alasanlepas"
                  id="tukar"
                  value="Tukar posisi"
                  class="form-check-input"
                />
                <label for="tukar" class="form-check-label">Tukar posisi</label>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "AddHistoryTire",
  created() {
    const { tireid } = this.$route.params;
    this.getTire(tireid);
  },
  data() {
    return {
      tire: {},
      service: {
        tire_id: null,
        user: null,
        kendaraan: null,
        tekanan_angin: "",
        tebal_tapak: [],
        posisi: "",
        jarakkm: "",
        catatan: "",
        kelainan: [],
        lepasban: false,
        alasanlepas: [],
        image: ""
      },
      error: [],
      imageData: null
    };
  },
  computed: {
    getUser() {
      return this.$store.getters.currentUser;
    }
  },
  methods: {
    getTire(id) {
      axios
        .get("/api/v1/tire/" + id)
        .then(res => {
          const { data } = res;
          // console.log("d", data);
          this.tire = data.data;
          this.service.user = this.getUser.id;
          this.service.tire_id = id;
          this.service.posisi = data.data.posistion;
          this.service.kendaraan = data.data.vehicle.id;
          this.$emit("back", "/vehicle/" + data.data.vehicle.id);
        })
        .catch(err => {
          // console.log(err.response.data);
          this.error = err.response.data;
        });
    },
    submitData() {
      let formData = new FormData();
      Object.keys(this.service).forEach(element => {
        if (typeof this.service[element] === "boolean")
          formData.append(element, this.service[element] ? 1 : 0);
        else formData.append(element, this.service[element]);
      });
      // console.log("formdata", [formData, this.service]);
      axios
        // .post("/api/v1/service/save", this.service)
        .post("api/v1/service/save", formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(res => {
          const { data } = res;
          this.$swal(data.message).then(val => {
            if (data.hasOwnProperty("redirect")) {
              // window.location
              this.$router.push({ path: data.redirect }, () => {
                window.location.reload();
              });
            } else {
              window.location.reload();
            }
          });
        })
        .catch(err => {
          this.error = err.response.data;
        });
    },

    lepasbanHandler() {
      this.$swal({
        title: "Anda Yakin?",
        text: "Apakah data Sudah benar?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya!"
      }).then(res => {
        if (res.value) {
          let service = this.service;
          service.lepasban = true;
          this.submitData();
        } else {
          // console.log("cancel");
        }
      });
    },
    previewImage() {
      this.service.image = this.$refs.file.files[0];
    }
  }
};
</script>

<style lang="scss">
fieldset {
  border-width: 2px;
  border-style: groove;
  // border-color: threedface;
  border-image: initial;
  padding: inherit;
  margin: inherit;
}
.file-upload-form,
.image-preview {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  padding: 20px;
}
img.preview {
  width: 200px;
  background-color: white;
  border: 1px solid #ddd;
  padding: 5px;
}
</style>
