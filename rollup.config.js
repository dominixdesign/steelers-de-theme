import { nodeResolve } from "@rollup/plugin-node-resolve";
import commonjs from "@rollup/plugin-commonjs";

export default {
  input: "src/js/main.js",
  output: {
    file: "dist/js/steelers-bundle.js",
    format: "iife",
  },
  plugins: [
    nodeResolve({
      jsnext: true,
      main: true,
      browser: true,
    }),
    commonjs(),
  ],
  external: ["lodash"],
};
