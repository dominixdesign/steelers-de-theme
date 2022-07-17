var LEftp = require("./tools/leftp.js");
require("dotenv").config();

var x = new LEftp({
  host: "steelers.de", // ftp host address, eg. my.server.com
  port: 21,
  user: process.env.FTP_USERNAME, // Your ftp username
  password: process.env.FTP_PASSWORD, // Your ftp password

  watchList: [
    {
      localRootDir: "dist/js",
      remoteRootDir: "/files/steelers/js",
    },
    {
      localRootDir: "dist/css",
      remoteRootDir: "/files/steelers/css",
    },
    {
      localRootDir: "templates",
      remoteRootDir: "/templates/steelers",
    },
    {
      localRootDir: "src/TilastotBundle/Tilastot",
      remoteRootDir: "/src/Tilastot",
    },
    {
      localRootDir: "src/TilastotBundle/Resources",
      remoteRootDir: "/src/Resources",
    },
    {
      localRootDir: "src/TilastotBundle/config",
      remoteRootDir: "/config",
    },
  ],
  // The following two parameters are depricated. Use watchList array instead
  // "localRootDir" : "C:/my/local/folder",	// Depricated, use watchList array instead
  // "remoteRootDir": 'public_html/remote/dir',	// Depricated, use watchList array instead

  frequency: 1, // Number of seconds between each scan
  ext: [".css", ".js", ".html", ".html5", "txt", "jpg", "json", ".php", ".yml"],
  onStartUploadAll: false, // On start, upload all files (that match the "watch criteria").
});
