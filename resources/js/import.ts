import { ComponentOptions } from "vue";

const modules = [] as any;

export interface IModule {
  default: ComponentOptions
}

export default function importComponent(componentName: string, url: string, timeout: number = 8000): Promise<ComponentOptions> {
    return new Promise((resolve, reject) => {

      if (modules[componentName]) {
            resolve(modules[componentName]);
            return;
        }

        const script = document.createElement("script");
        const tempGlobal = "__tempModuleLoadingVariable" + Math.random().toString(32).substring(2);
        script.type = "module";
        script.textContent = `import * as m from "${url}";`;

        document.head.appendChild(script);

        let maxTries = Math.round(timeout / 200);
        let check = function (tries: number) {
          console.log(componentName, window)
            if ((componentName in window)) {
                console.log("READY", window[componentName]);
                let module: IModule = window[componentName] as IModule;
                modules[componentName] = module.default;
                resolve(module.default);
                delete window[tempGlobal];
                script.remove();
            } else {
              console.log("NOT READY");

              if (tries >= maxTries && maxTries !== 0) {
                  console.log('STOP');
                  return ;
                }
                setTimeout(check, 200, tries + 1);
            }
        }
        setTimeout(check, 200, 1);
    });
}
