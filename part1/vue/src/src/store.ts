// store.ts
import { InjectionKey } from 'vue';
import { createStore, Store } from 'vuex';

// Define your state interface
export interface State {
  token: string | null;
}

// Define injection key
export const key: InjectionKey<Store<State>> = Symbol();

export const store = createStore<State>({
  state: {
    token: null,
  },
  mutations: {
    saveToken(state, token: string) {
      state.token = token;
    },
  },
});
