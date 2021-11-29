package route

import (
	"io/ioutil"
	"strings"

	"github.com/gin-contrib/sessions"
	"github.com/gin-gonic/gin"
)

func SetRoute(app *gin.Engine) {
	app.GET("/", func(c *gin.Context) {
		sess := sessions.Default(c)
		sess.Set("user", "guest")
		sess.Save()

		c.JSON(200, gin.H{
			"user": sess.Get("user"),
		})
	})

	app.GET("/flag", func(c *gin.Context) {
		sess := sessions.Default(c)
		user := sess.Get("user").(string)
		if strings.Compare(user, "admin") == 0 {
			data, _ := ioutil.ReadFile("/flag")
			c.JSON(200, gin.H{
				"flag": string(data),
			})
		} else {
			c.JSON(200, gin.H{
				"No!": "U are not admin!",
			})
		}
	})
}
