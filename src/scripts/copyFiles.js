const watchList = require("../../targets.json");

const fs = require("fs");

for (folders of watchList) {
  fs.cp(
    `../../${folders.localRootDir}/`,
    `../../../..${folders.remoteRootDir}/`,
    { recursive: true },
    (e) => {
      console.log(e);
    }
  );
}
