var LEftp = require("./tools/leftp.js");
require("dotenv").config();
const watchList = require("./targets.json");
const argv = process.argv;

let onStartUploadAll = false;

if (argv[2] === "deploy") {
  onStartUploadAll = true;
}

var x = new LEftp({
  host: "steelers.de",
  port: 22,
  user: process.env.FTP_USERNAME || argv[3],
  password: process.env.FTP_PASSWORD || argv[4],
  watchList,
  frequency: 1, // Number of seconds between each scan
  ext: [
    ".css",
    ".js",
    ".html",
    ".html5",
    "txt",
    "jpg",
    "json",
    ".php",
    ".yml",
    ".sh",
  ],
  onStartUploadAll, // On start, upload all files (that match the "watch criteria").
});

if (onStartUploadAll) {
  setTimeout(() => x.stop(), 5000);
}
