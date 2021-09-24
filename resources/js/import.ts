import { ComponentOptions } from "vue";
import { IModule, ISlideContext, SlideModule } from "dynamicscreen-sdk-js";

const modules = [] as any;

// export async function importComponent(componentName: string, name: string, url: string, timeout: number = 8000): Promise<ComponentOptions> {
//   return new Promise(async (resolve, reject) => {
//     const module: IModule = await importModule(componentName, name, url, timeout);
//     //@ts-ignore
//     const con = module.default;
//     console.log(con, name, window, modules)
//     let slideModule: SlideModule = new con(context);
//
//     // @ts-ignore
//     resolve(slideModule.component);
//   });
// }

export async function importModule(componentName: string, name: string, url: string, timeout: number = 8000): Promise<IModule> {
    return new Promise((resolve, reject) => {

      if (modules[name]) {
        resolve(modules[name]);
        return;
      }

      const script = document.createElement("script");
      const tempGlobal = "__tempModuleLoadingVariable" + Math.random().toString(32).substring(2);

      script.onload = function () {
        setTimeout(check, 200, 1);
        console.log("EXTERNAL SCRIPT LOADED")
      };

      script.src = url;
      document.head.appendChild(script);

      let maxTries = Math.round(timeout / 200);
      let check = function (tries: number) {
        console.log(componentName, window)
        if ((componentName in window)) {
          let module: IModule = window[componentName] as IModule;
          console.log('RESOLVING COMPONENT MODULE', module, modules);
          modules[name] = module;
          resolve(module);
          delete window[tempGlobal];
          script.remove();
        } else {
          if (tries >= maxTries && maxTries !== 0) {
            console.log('STOP COMPONENT LOADING');
            return ;
          }
          setTimeout(check, 200, tries + 1);
        }
      }
    });
}

export async function importComponentOptions(componentName: string, name: string,  url: string, timeout: number = 8000): Promise<ComponentOptions> {
  return new Promise((resolve, reject) => {
    //
    // if (modules[componentName]) {
    //   resolve(modules[componentName]);
    //   return;
    // }

    if (modules[name]) {
      resolve(modules[name]);
      return;
    }

    const script = document.createElement("script");
    const tempGlobal = "__tempModuleLoadingVariable" + Math.random().toString(32).substring(2);

    script.onload = function () {
      setTimeout(check, 200, 1);
      console.log("EXTERNAL SCRIPT LOADED OPTIONS")
    };

    script.src = url;
    document.head.appendChild(script);

    let maxTries = Math.round(timeout / 200);
    let check = function (tries: number) {
      console.log(componentName, window)
      if ((componentName in window)) {
        let module = window[componentName].default;
        console.log('RESOLVING COMPONENT OPTIONS MODULE', module, modules);
        modules[module.name] = module;
        //@ts-ignore
        resolve(module);
        delete window[tempGlobal];
        script.remove();
      } else {
        if (tries >= maxTries && maxTries !== 0) {
          console.log('STOP COMPONENT LOADING');
          return ;
        }
        setTimeout(check, 200, tries + 1);
      }
    }
  });
}
