import { defineStore } from 'pinia'
import { updateBodyClass, updateTitle, updateSelectorClass, updateDomValueBySetting, updateHtmlClass, updateHtmlAttr, updateStorage, getStorage, updateColorRootVar } from '../utilities/setting'
import { initialState as state, defaultState, dropdown } from './state'
import _ from 'lodash'

const DefaultSetting = defaultState.setting

const Choices = {
  SidebarShow: DefaultSetting.sidebar_show.choices,
  HeaderBanner: DefaultSetting.header_banner.choices,
  HeaderNavbarStyle: DefaultSetting.header_navbar.choices,
  NavbarShow: DefaultSetting.navbar_show.choices,
  SidebarMenuStyle: DefaultSetting.sidebar_menu_style.choices,
  FooterStyle: DefaultSetting.footer_style.choices,
  SidebarType: DefaultSetting.sidebar_type.choices,
  MenuColor: DefaultSetting.sidebar_color.choices,
  pagestyle: DefaultSetting.page_layout.choices,
  ColorChoice: DefaultSetting.theme_color.choices,
  StyleAppearanceChoice: DefaultSetting.theme_style_appearance.choices,
  FSChoice: DefaultSetting.theme_font_size.choices,
  Animation: DefaultSetting.theme_transition.choices,
  CardStyle: DefaultSetting.card_style.choices
}
const createSettingObj = (state) => {
  return {
    saveLocal: state.saveLocal,
    storeKey: state.storeKey,
    setting: _.cloneDeep(state.setting)
  }
}

export const useSetting = defineStore('setting', {
  state: () => ({ ...state }),
  getters: {
    theme_color_custom: (state) => state.setting.theme_color,
    card_style_value: (state) => state.setting.card_style.value,
    header_navbar_value: (state) => state.setting.header_navbar.value,
    footer_style_value: (state) => state.setting.footer_style.value,
    sidebar_color_value: (state) => state.setting.sidebar_color.value,
    sidebar_menu_style_value: (state) => state.setting.sidebar_menu_style.value,
    sidebar_type_value: (state) => state.setting.sidebar_type.value,
  },
  actions: {
    setSetting() {
      const json = getStorage(this.storeKey)
      if (json === 'none') this.saveLocal = 'none'
      if (json !== null && json !== 'none') {
        this.saveLocal = json.saveLocal
        this.setting = json.setting
      }
      updateDomValueBySetting(_.cloneDeep(this.setting), Choices)
      updateStorage(this.saveLocal, this.storeKey, createSettingObj(this))
    },
    reset_state() {
      this.setting = defaultState.setting
      updateDomValueBySetting(this.setting, Choices)
      updateStorage(this.saveLocal, this.storeKey, createSettingObj(this))
    },
    save_local(payload) {
      if (typeof payload !== typeof undefined) {
        this.saveLocal = payload
      }
      const settingObj = {
        saveLocal: this.saveLocal,
        storeKey: this.storeKey,
        setting: _.cloneDeep(this.setting)
      }
      updateStorage(this.saveLocal, this.storeKey, settingObj)
    },
    header_banner(payload) {
      this.setting.header_banner.value = payload
      updateStorage(this.saveLocal, this.storeKey, createSettingObj(this))
    },
    app_name(payload) {
      if (typeof payload !== typeof undefined) {
        this.setting.app_name.value = payload
      }
      updateTitle(this.setting.app_name.value)
      updateStorage(this.saveLocal, this.storeKey, createSettingObj(this))
    },
    theme_style_appearance(payload) {
      if (typeof payload !== typeof undefined) {
        this.setting.theme_style_appearance.value = payload
      }
      updateBodyClass(Choices.StyleAppearanceChoice, this.setting.theme_style_appearance.value)
      updateStorage(this.saveLocal, this.storeKey, createSettingObj(this))
    },
    page_layout(payload) {
      this.setting.page_layout.value = payload
    },
    theme_transition(payload) {
      if (typeof payload !== typeof undefined) {
        this.setting.theme_transition.value = payload
      }
      updateBodyClass(Choices.Animation, this.setting.theme_transition.value)
      updateStorage(this.saveLocal, this.storeKey, createSettingObj(this))
    },
    theme_scheme_direction(payload) {
      if (typeof payload !== typeof undefined) {
        this.setting.theme_scheme_direction.value = payload
      }
      updateHtmlAttr({ prop: 'dir', value: this.setting.theme_scheme_direction.value })
      updateStorage(this.saveLocal, this.storeKey, createSettingObj(this))
    },
    theme_color(payload) {
      if (typeof payload !== typeof undefined) {
        _.forEach(payload.colors, (value, key) => {
          this.setting.theme_color.colors[key] = value
        })
        this.setting.theme_color.value = payload.value
      }
      updateHtmlAttr({ prop: 'data-bs-theme-color', value: this.setting.theme_color.value })
      updateColorRootVar(this.setting.theme_color.value, this.setting.theme_color, Choices.ColorChoice)
      updateStorage(this.saveLocal, this.storeKey, createSettingObj(this))
    },
    theme_font_size(payload) {
      if (typeof payload !== typeof undefined) {
        this.setting.theme_font_size.value = payload
      }
      updateHtmlClass(Choices.FSChoice, this.setting.theme_font_size.value)
      updateStorage(this.saveLocal, this.storeKey, createSettingObj(this))
    },
    header_navbar(payload) {
      this.setting.header_navbar.value = payload
      updateStorage(this.saveLocal, this.storeKey, createSettingObj(this))
      updateSelectorClass('.iq-navbar', Choices.HeaderNavbarStyle, this.setting.header_navbar.value)
    },
    card_style(payload) {
      this.setting.card_style.value = payload
      updateBodyClass(Choices.CardStyle, this.setting.card_style.value)
      updateStorage(this.saveLocal, this.storeKey, createSettingObj(this))
    },
    sidebar_type(payload) {
      this.setting.sidebar_type.value = payload
      const payloadString = payload.toString();
      const newClass = payloadString.replace(/,/g, ' ')
      updateSelectorClass('[data-toggle="main-sidebar"]', Choices.SidebarType, newClass, state.setting.sidebar_type.value)
    },
    sidebar_color(payload) {
      this.setting.sidebar_color.value = payload
      updateStorage(this.saveLocal, this.storeKey, createSettingObj(this))
      updateSelectorClass('[data-toggle="main-sidebar"]', Choices.MenuColor, this.setting.sidebar_color.value)
    },
    sidebar_menu_style(payload) {
      this.setting.sidebar_menu_style.value = payload
      updateSelectorClass('[data-toggle="main-sidebar"]', Choices.SidebarMenuStyle, this.setting.sidebar_menu_style.value)
      updateStorage(this.saveLocal, this.storeKey, createSettingObj(this))
    },
    sidebar_show(payload) {
      this.setting.sidebar_show.value = payload
      updateStorage(this.saveLocal, this.storeKey, createSettingObj(this))
      updateSelectorClass('[data-toggle="main-sidebar"]', Choices.SidebarShow, this.setting.sidebar_show.value)
    },
    navbar_show(payload) {
      this.setting.navbar_show.value = payload
      updateStorage(this.saveLocal, this.storeKey, createSettingObj(this))
      updateSelectorClass('.navbar', Choices.NavbarShow, this.setting.navbar_show.value)
    },
    footer_style(payload) {
      this.setting.footer_style.value = payload
      updateStorage(this.saveLocal, this.storeKey, createSettingObj(this))
      updateSelectorClass('.footer', Choices.FooterStyle, this.setting.footer_style.value)
    }
  }
})
window.pinia = useSetting
