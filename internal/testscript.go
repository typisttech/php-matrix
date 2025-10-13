package internal

import (
	"os"
	"testing"

	"github.com/rogpeppe/go-internal/testscript"
)

func RunTestscript(t *testing.T) {
	testscript.Run(t, testscript.Params{
		Dir: "testdata",
		Setup: func(env *testscript.Env) error {
			env.Setenv("COLUMNS", "120") // https://github.com/symfony/console/blob/2b9c5fafbac0399a20a2e82429e2bd735dcfb7db/Style/SymfonyStyle.php#L44
			return nil
		},
		UpdateScripts: os.Getenv("UPDATE_SCRIPTS") == "1",
	})
}
