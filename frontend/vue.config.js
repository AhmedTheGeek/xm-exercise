module.exports = {
    chainWebpack: config => {
        config
            .plugin('html')
            .tap(args => {
                args[0].title = "Ahmed XM.com Exercise";
                return args;
            })
    }
}
