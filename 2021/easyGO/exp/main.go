package main

import (
	"github.com/gin-contrib/sessions"
	"github.com/gin-contrib/sessions/cookie"
	"github.com/gin-gonic/gin"
)

func main() {
	webapp := gin.Default()
	store := cookie.NewStore([]byte("WTF_HOw_d1d_U_kn0W_Th1s"))

	webapp.Use(sessions.Sessions("PHPSESSION", store))
	webapp.Use(gin.Recovery())

	webapp.GET("/", func(c *gin.Context) {
		sess := sessions.Default(c)
		sess.Set("user", "admin")
		sess.Save()
	})

	webapp.Run(":7777")
}
