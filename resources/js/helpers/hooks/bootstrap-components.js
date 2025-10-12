import { ref, onUnmounted } from "vue";

export const useModel = (callback, event_name = 'model') => {
  // Module Current ID Logic
  const model = ref(false);

  const updateModalValue = (e) => {
      model.value = e.detail.show;
      callback()
  };

  document.addEventListener(event_name, updateModalValue);

  onUnmounted(() => window.removeEventListener(event_name, updateModalValue));

  return model;
};
