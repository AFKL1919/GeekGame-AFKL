package main

import (
	"SYC/geek/route"

	"github.com/gin-contrib/sessions"
	"github.com/gin-contrib/sessions/cookie"
	"github.com/gin-gonic/gin"
)

func main() {
	webapp := gin.Default()
	store := cookie.NewStore([]byte("WTF_HOw_d1d_U_kn0W_Th1s"))

	webapp.Use(sessions.Sessions("PHPSESSION", store))
	webapp.Use(gin.Recovery())

	webapp.Static("/static", "./")

	route.SetRoute(webapp)
	webapp.Run(":8080")
}
