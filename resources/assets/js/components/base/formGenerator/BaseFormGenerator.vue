<template>
  <div>      
    <component 
      v-for="(field, index) in schema" 
      v-bind="field"
      :key="index"        
      :value="formData[field.name]"   
      :is="componentName(field.type)"    
      @input="updateForm(field.name, $event)"
    />          
  </div>    
</template>

<script>
import FGenDate from "./FGenDate.vue";
import FGenRadio from "./FGenRadio.vue";
import FGenTextbox from "./FGenTextbox.vue";
import FGenTextarea from "./FGenTextarea.vue";
import FGenCheckbox from "./FGenCheckbox.vue";
import FGenSelectbox from "./FGenSelectbox.vue";
import FGenNumber from "./FGenNumber.vue";

export default {
  name: "BaseFormGenerator",

  components: {
    FGenTextbox,
    FGenTextarea,
    FGenSelectbox,
    FGenDate,
    FGenCheckbox,
    FGenRadio,
    FGenNumber
  },

  props: ["schema", "value"],

  data() {
    return {
      formData: this.value || {}
    };
  },

  watch:{
    value: function(value){      
      this.formData = value;
    }
  },
  
  methods: {
    updateForm(fieldName, value) {
      this.$set(this.formData, fieldName, value);
      this.$emit("input", this.formData);
    },
    componentName(type) {
      switch (type) {
        case "text":
          return "FGenTextbox";
        case "date":
          return "FGenDate";
        case "number":
          return "FGenNumber";
        case "file":
          return "FGenFile";
        case "textarea":
          return "FGenTextarea";
        case "select":
          return "FGenSelectbox";
        case "radio-group":
          return "FGenRadio";
        case "checkbox-group":
          return "FGenCheckbox";

        default:
          return "";
      }
    }
  }
};
</script>

<style scoped>
</style>
